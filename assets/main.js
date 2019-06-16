$(document).ready(function () {
    var form = $('#form');

    var getLocation = function (href) {
        var l = document.createElement("a");
        l.href = href;
        return l;
    };

    $('#send').click(function (e) {
        document.getElementById("send").disabled = true;
        var url = $('#url').val();
        var parseUrl = getLocation(url);
        if (parseUrl.hostname == "twitter.com") {
            var fail = "";
            var cb = new Codebird;
            var tweet_url = url;
            cb.setConsumerKey("K0w8rlDCB6zBB739TGt1BLY2n", "3dk9oqc7CQoI90fCyk9JcZEvS88bvkP1YHxI3ylyorl1cNaD5H");
            cb.setProxy(base_url() + "/assets/codebird-cors-proxy/");
            var s_url = tweet_url.split("/")[5];
            if ((tweet_url.indexOf("twitter.com") == -1) || s_url == undefined) {
                fail += "Please enter a valid twitter link";
                failure(fail);
                return fail;
            } else {
                var valid = 1;
                var videoUrl;
                cb.__call(
                    "statuses_show_ID",
                    "id=" + s_url,
                    null,
                    true
                ).then(function (data) {
                    if (data.reply.extended_entities == null && data.reply.entities.media == null) {
                        valid = 0;
                        fail += "The tweet content is not accessible).";
                    }
                    else if ((data.reply.extended_entities.media[0].type) != "video" && (data.reply.extended_entities.media[0].type) != "animated_gif") {
                        valid = 0;
                        fail += "The tweet contains no video or gif file (or it is not accessible).";
                    } else {
                        videoUrl = data.reply.extended_entities.media[0].video_info.variants[0].url;
                        $.post('system/action.php', {url: videoUrl}, function (data) {
                            $('#modal-container').html(data);
                            $('#modal').modal();
                            document.getElementById("send").disabled = false;
                        });
                    }
                });
            }
        } else {
            $.post('system/action.php', {url: url}, function (data) {
                $('#modal-container').html(data);
                $('#modal').modal();
                document.getElementById("send").disabled = false;
            });
        }
        e.preventDefault();
    });

    function base_url() {
        var pathparts = location.pathname.split('/');
        if (location.host == 'localhost') {
            var url = location.origin + '/' + pathparts[1].trim('/') + '/';
        } else {
            var url = location.origin;
        }
        return url;
    }

    function failure(fail) {
        $.post('system/action.php', {url: fail}, function (data) {
            $('#modal-container').html(data);
            $('#modal').modal();
            document.getElementById("send").disabled = false;
        });
    }
});