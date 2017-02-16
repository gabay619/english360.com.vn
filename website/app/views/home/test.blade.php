<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>DGT Present</title>
    <script type="text/javascript" src="/assets/lib/jwplayer/jwplayer.js"></script>
    <script type="text/javascript">jwplayer.key="BdmcBP4sG4W6RjYSbz5mgrt3LnBDB3ZWvFTDlP9FBj9KK6JOtwDLpKnJXgo=";</script>
</head>
<body>
<center>
    <div id="myElement">Loading the player...</div>

    <script type="text/javascript">
        jwplayer("myElement").setup({
            file: "/assets/test/video.mp4",
            image: "/assets/images/3g.png",
            skin: 'bekle',
            tracks: [{
                file: "/assets/test/subAnh.srt",
                label: "English",
                kind: "captions",
                "default": true
            },{
                file: "/assets/test/subViet.srt",
                kind: "captions",
                label: "Tiếng Việt"
            }],
            captions: {
                color: '#fff',
//                fontSize: 20,
                backgroundOpacity: 50
            }
        });
    </script>
</center>
</body>
</html>