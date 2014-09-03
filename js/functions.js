function GetDateDiff(startTime, endTime, diffType) {
        //将xxxx-xx-xx的时间格式，转换为 xxxx/xx/xx的格式 
        startTime = startTime.replace(/\-/g, "/");
        endTime = endTime.replace(/\-/g, "/");
        //将计算间隔类性字符转换为小写 
        diffType = diffType.toLowerCase();
        var sTime = new Date(startTime); //开始时间 
        var eTime = new Date(endTime); //结束时间 
        //作为除数的数字 
        var divNum = 1;
        switch (diffType) {
        case "second":
                divNum = 1000;
                break;
        case "minute":
                divNum = 1000 * 60;
                break;
        case "hour":
                divNum = 1000 * 3600;
                break;
        case "day":
                divNum = 1000 * 3600 * 24;
                break;
        default:
                break;
        }
        return parseInt((eTime.getTime() - sTime.getTime()) / parseInt(divNum));
}

function getJsArg() {
        var all_script_tags = document.getElementsByTagName('script');
        var script_tag = all_script_tags[all_script_tags.length - 1];
        // Get the query string from the embedded SCRIPT tag's src attribute
        var query = script_tag.src.replace(/^[^\?]+\??/, '');
        // Parse query string into arguments/parameter
        var vars = query.split("&");
        var args = {};
        for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                args[pair[0]] = decodeURI(pair[1]).replace(/\+/g, ' '); // decodeURI doesn't expand "+" to a space
        }
        // Output detected arguments
        return args.activity_code;
}