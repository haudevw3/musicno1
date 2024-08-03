const BASE_URL = "https://musicno1.xyz/";

var _apiGet = async function (url, data, _options = {}) {
    var result;
    var options = {..._options};
    try {
        result = await $.ajax({
            url: url,
            type: "GET",
            data: data,
            dataType: options.dataType ? options.dataType : "json",
            success: function (response) { 
            },
            error: function (error) {
            },
        });
    } catch (error) {
        console.log(error);
    }
    return result;
}