<?php

namespace Modules\FileManager;

use Illuminate\Http\UploadedFile;

class FileParser
{
    /**
     * The file name does not contain the mime type.
     *
     * @var string
     */
    protected $name;

    /**
     * The file type.
     *
     * @var string
     */
    protected $type;

    /**
     * The file size. (KB)
     *
     * @var int
     */
    protected $size;

    /**
     * The file URL.
     *
     * @var string
     */
    protected $url;

    /**
     * The file mime type.
     *
     * @var string
     */
    protected $mimeType;

    /**
     * The file mime type allows.
     *
     * @var array
     */
    protected $mimeTypes = [
        'image' => ['image/jpeg', 'image/jpg', 'image/png'],
        'audio' => ['audio/mpeg', 'audio/mp3'],
    ];

    /**
     * The "uploaded file" instance.
     *
     * @var \Illuminate\Http\UploadedFile
     */
    protected $file;

    /**
     * Create a new "uploaded file" instance.
     *
     * @param \Illuminate\Http\UploadedFile  $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $this->mimeType = $file->getMimeType();

        $this->setType($this->mimeType);
        $this->setSize($file->getSize());
        $this->setName($file->getClientOriginalName());
    }

    /**
     * Get the file name.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Set the file name with the given value.
     * 
     * @param  string  $name
     * @return void
     */
    protected function setName($name)
    {
        $this->name = $this->parseName($name);
    }

    /**
     * Parse the file name and return the name that does not contain the mime type.
     *
     * @param  string  $name
     * @return string
     */
    protected function parseName($name)
    {
        $segments = explode('.', $name);

        unset($segments[count($segments) - 1]);

        $name = implode('.', $segments);

        return $name;
    }

    /**
     * Get the file mime type.
     *
     * @return string
     */
    public function mimeType()
    {
        return $this->mimeType;
    }

    /**
     * Get the file primary type.
     *
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Set the file type with the given value.
     *
     * @param  string  $mimeType
     * @return void
     */
    protected function setType($mimeType)
    {
        $this->type = $this->parseMimeType($mimeType);
    }

    /**
     * Parse the file mime type and return the file primary type.
     *
     * @param  string  $mimeType
     * @return string
     */
    protected function parseMimeType($mimeType)
    {
        $segments = explode('/', $mimeType);

        $type = end($segments);

        return $type;
    }

    /**
     * Get the file size.
     *
     * @return int
     */
    public function size()
    {
        return $this->size;
    }

    /**
     * Set the file size with the given value.
     *
     * @param  float  $bytes
     * @return void
     */
    protected function setSize($bytes)
    {
        $this->size = $this->parseSize($bytes);
    }

    /**
     * Parse the file size and format it to "KB".
     *
     * @param  int  $bytes
     * @return int
     */
    protected function parseSize($bytes)
    {
        return typecast($kb = $bytes / 1024, 'int');
    }

    /**
     * Determine if the "mime type" is allowed.
     *
     * @param  string  $type
     * @return bool
     */
    public function isMimeType($type = 'audio')
    {
        return isset($this->mimeTypes[$type][$this->mimeType]);
    }

    /**
     * Store files in the directory "public/uploads".
     *
     * @return $this
     */
    public function store()
    {
        $name = strtolower(str_random().'.'.$this->type);

        $path = public_path(
            'uploads'.DIRECTORY_SEPARATOR.($this->isMimeType() ? 'audios' : 'images')
        );

        $this->url = 'uploads/'.($this->isMimeType() ? 'audios' : 'images').'/'.$name;

        $this->file->move($path, $name);

        return $this;
    }

    /**
     * Get the URL of the file.
     *
     * @return string
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * Get property array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name(),
            'type' => $this->type(),
            'size' => $this->size(),
            'url' => $this->url(),
        ];
    }
}