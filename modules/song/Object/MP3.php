<?php

namespace Modules\Song\Object;

class MP3
{
    protected $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    // As hh:mm:ss
    public function format($duration)
    {
        $hours = floor($duration / 3600);
        $minutes = floor( ($duration - ($hours * 3600)) / 60);
        $seconds = $duration - ($hours * 3600) - ($minutes * 60);
        // return sprintf('%d:%02d', $duration / 60, $duration % 60);
        // return sprintf('%02d:%02d%02d', $hours, $minutes, $seconds);
        if ($hours >= 1) {
            return sprintf('%02d giờ %02d phút', $hours, $minutes);
        } else {
            return sprintf('%02d:%02d', $minutes, $seconds);
        }
    }

    // Read first mp3 frame only...use for CBR constant bit rate MP3s
    public function durationEstimate()
    {
        return $this->duration(true);
    }

    // Read entire file, frame by frame...ie: Variable Bit Rate (VBR)
    public function duration($useCbrEstimate = false)
    {
        $fd = fopen($this->fileName, 'rb');
        $duration = 0;
        $block = fread($fd, 100);
        $offset = $this->skipID3v2Tag($block);
        fseek($fd, $offset, SEEK_SET);
        while (!feof($fd)) {
            $block = fread($fd, 10);
            if (strlen($block) < 10) {
                break;
            } else if ($block[0] == "\xff" && (ord($block[1]) & 0xe0)) { //looking for 1111 1111 111 (frame synchronization bits)
                $info = self::parseFrameHeader(substr($block, 0, 4));
                if (empty($info['Framesize'])) {
                    return $duration; //some corrupt mp3 files
                }
                fseek($fd, $info['Framesize'] - 10, SEEK_CUR);
                $duration += ($info['Samples'] / $info['Sampling Rate']);
            } else if (substr($block, 0, 3) == 'TAG') {
                fseek($fd, 128 - 10, SEEK_CUR); //skip over id3v1 tag size
            } else {
                fseek($fd, -9, SEEK_CUR);
            }

            if ($useCbrEstimate && !empty($info)) {
                return $this->estimateDuration($info['Bitrate'], $offset);
            }
        }
        return round($duration);
    }

    private function estimateDuration($bitrate, $offset)
    {
        $kbps = ($bitrate * 1000) / 8;
        $datasize = filesize($this->fileName) - $offset;
        return round($datasize / $kbps);
    }

    private function skipID3v2Tag(&$block)
    {
        if (substr($block, 0, 3) == "ID3") {
            $id3v2MajorVersion = ord($block[3]);
            $id3v2MinorVersion = ord($block[4]);
            $id3v2Flags = ord($block[5]);
            $flagUnsynchronisation = $id3v2Flags & 0x80 ? 1 : 0;
            $flagExtendedHeader    = $id3v2Flags & 0x40 ? 1 : 0;
            $flagExperimentalInd   = $id3v2Flags & 0x20 ? 1 : 0;
            $flagFooterPresent     = $id3v2Flags & 0x10 ? 1 : 0;
            $z0 = ord($block[6]);
            $z1 = ord($block[7]);
            $z2 = ord($block[8]);
            $z3 = ord($block[9]);
            if ((($z0 & 0x80) == 0) && (($z1 & 0x80) == 0) && (($z2 & 0x80) == 0) && (($z3 & 0x80) == 0)) {
                $headerSize = 10;
                $tagSize = (($z0 & 0x7f) * 2097152) + (($z1 & 0x7f) * 16384) + (($z2 & 0x7f) * 128) + ($z3 & 0x7f);
                $footerSize = $flagFooterPresent ? 10 : 0;
                return $headerSize + $tagSize + $footerSize; //bytes to skip
            }
        }
        return 0;
    }

    public static function parseFrameHeader($fourbytes)
    {
        static $versions = array(
            0x0 => '2.5', 0x1 => 'x', 0x2 => '2', 0x3 => '1', // x=>'reserved'
        );
        static $layers = array(
            0x0 => 'x', 0x1 => '3', 0x2 => '2', 0x3 => '1', // x=>'reserved'
        );
        static $bitrates = array(
            'V1L1' => array(0, 32, 64, 96, 128, 160, 192, 224, 256, 288, 320, 352, 384, 416, 448),
            'V1L2' => array(0, 32, 48, 56, 64, 80, 96, 112, 128, 160, 192, 224, 256, 320, 384),
            'V1L3' => array(0, 32, 40, 48, 56, 64, 80, 96, 112, 128, 160, 192, 224, 256, 320),
            'V2L1' => array(0, 32, 48, 56, 64, 80, 96, 112, 128, 144, 160, 176, 192, 224, 256),
            'V2L2' => array(0, 8, 16, 24, 32, 40, 48, 56, 64, 80, 96, 112, 128, 144, 160),
            'V2L3' => array(0, 8, 16, 24, 32, 40, 48, 56, 64, 80, 96, 112, 128, 144, 160),
        );
        static $sampleRates = array(
            '1'   => array(44100, 48000, 32000),
            '2'   => array(22050, 24000, 16000),
            '2.5' => array(11025, 12000, 8000),
        );
        static $samples = array(
            1 => array(1 => 384, 2 => 1152, 3 => 1152,), //MPEGv1,     Layers 1,2,3
            2 => array(1 => 384, 2 => 1152, 3 => 576,), //MPEGv2/2.5, Layers 1,2,3
        );
        //$b0=ord($fourbytes[0]);//will always be 0xff
        $b1 = ord($fourbytes[1]);
        $b2 = ord($fourbytes[2]);
        $b3 = ord($fourbytes[3]);

        $versionBits = ($b1 & 0x18) >> 3;
        $version = $versions[$versionBits];
        $simpleVersion =  ($version == '2.5' ? 2 : $version);

        $layerBits = ($b1 & 0x06) >> 1;
        $layer = $layers[$layerBits];

        $protectionBit = ($b1 & 0x01);
        $bitrateKey = sprintf('V%dL%d', $simpleVersion, $layer);
        $bitrateIdx = ($b2 & 0xf0) >> 4;
        $bitrate = isset($bitrates[$bitrateKey][$bitrateIdx]) ? $bitrates[$bitrateKey][$bitrateIdx] : 0;

        $sampleRateIdx = ($b2 & 0x0c) >> 2; //0xc => b1100
        $sampleRate = isset($sampleRates[$version][$sampleRateIdx]) ? $sampleRates[$version][$sampleRateIdx] : 0;
        $paddingBit = ($b2 & 0x02) >> 1;
        $privateBit = ($b2 & 0x01);
        $channelModeBits = ($b3 & 0xc0) >> 6;
        $modeExtensionBits = ($b3 & 0x30) >> 4;
        $copyrightBit = ($b3 & 0x08) >> 3;
        $originalBit = ($b3 & 0x04) >> 2;
        $emphasis = ($b3 & 0x03);

        $info = array();
        $info['Version'] = $version; //MPEGVersion
        $info['Layer'] = $layer;
        //$info['Protection Bit'] = $protectionBit; //0=> protected by 2 byte CRC, 1=>not protected
        $info['Bitrate'] = $bitrate;
        $info['Sampling Rate'] = $sampleRate;
        //$info['Padding Bit'] = $paddingBit;
        //$info['Private Bit'] = $privateBit;
        //$info['Channel Mode'] = $channelModeBits;
        //$info['Mode Extension'] = $modeExtensionBits;
        //$info['Copyright'] = $copyrightBit;
        //$info['Original'] = $originalBit;
        //$info['Emphasis'] = $emphasis;
        $info['Framesize'] = self::framesize($layer, $bitrate, $sampleRate, $paddingBit);
        $info['Samples'] = $samples[$simpleVersion][$layer];
        return $info;
    }

    private static function framesize($layer, $bitrate, $sampleRate, $paddingBit)
    {
        if ($layer == 1) {
            return intval(((12 * $bitrate * 1000 / $sampleRate) + $paddingBit) * 4);
        } else {
            return intval(((144 * $bitrate * 1000) / $sampleRate) + $paddingBit); //layer 2, 3
        }
    }
}
