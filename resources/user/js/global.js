const BASE_URL = "https://musicno1.xyz/";
const PAGE_HOME = "home";
const PAGE_TOP100 = "top-100";
const PAGE_CATEGORIES = "categories";

var _apiGet = async function (url, data, _options = {}) {
    var result;
    try {
        result = await $.ajax({
            url: url,
            type: "GET",
            data: data,
            dataType: "json",
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