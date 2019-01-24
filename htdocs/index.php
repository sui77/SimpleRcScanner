<?php
session_start();
?><html>
<head>
    <title>rc-switch raw data viewer</title>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
</head>
<body>
<a href="./Sketchbook/SimpleRcScanner.ino">Arduino Sketch</a> | <a href="https://github.com/sui77/rc-switch">rc-switch</a> | <a href="https://github.com/sui77/SimpleRcScanner">$this source</a>
<hr>
<form id="dataform" method="post">
    <textarea placeholder="Paste comma separated values from rc-switch ReceiveDemo_Advance or SimpleRcScanner sketch here." id="data" style="width:100%;height:50px"></textarea>
    <input type="submit">
</form>

<div id="results"> 
</div>
  
<script>
$(function() {
    $('#dataform').submit(function(e) {
        e.preventDefault();

        $.post('ajax.php', {data: $('#data').val()}, function( data ) {
            var r = $('<div class="' + data.name + '" style="width:100%;height:170px;overflow:auto;"><img src="' + data.href + '"><div class="js-close" data-cid="' + data.name + '" style="position:absolute;background-color:#ccc;font-family:arial,sans-serif;font-size:10px;margin:4px;cursor:pointer;">close</div></div>');
            $('#results').prepend(r);
            $('#data').val('');
        });

    });
    $(document).on('click', '.js-close', function(el) {
        $('.' + $(this).data('cid') ).remove();
    });
});
</script>
