<?php
include 'includes/db_connect.php';
include 'Models/Items.php';

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=us-ascii"/>
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <link rel="stylesheet" media="screen" type="text/css" href="css/colorpicker.css"/>
    <title></title>
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="js/colorpicker.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            inputs = document.getElementsByTagName('li');
            count = 0;

            $('.colortab').ColorPicker({
                color: '#000',
                onShow: function (colpkr) {
                    $(colpkr).fadeIn(500);
                    return false;
                },
                onHide: function (colpkr) {
                    $(colpkr).fadeOut(500);
                    return false;
                },
                onChange: function (hsb, hex, rgb) {
                    $('#' + spanID + 'listitem').css('backgroundColor', '#' + hex);
                }
            });

            $("#add-new-submit").click(function () {
                var txtname = $("#new-list-item-text").val();
                var dataString = 'NAME=' + txtname;

                $.ajax
                ({
                    type: "POST",
                    url: "add.php",
                    data: dataString,
                    dataType: "JSON",
                    cache: false,
                    success: function (e) {
                        var name = e;
                        console.log(name.item);
                        sayHello(name.item);
                        //colorChange();
                    }
                });
            });
            $("li > div.deletetab").click(function () {
                var id = $(this).closest('li').attr("value");
                var dataString = 'ID=' + id;
                alert(dataString);
                $(this).parent('li').remove();
                $.ajax
                ({
                    type: "POST",
                    url: "delete.php",
                    data: dataString,
                    cache: false,
                    success: function (e) {
                        console.log("Delete successfully!!");
                    }
                });
            });

            $('.test').on('click', function () {
                var that = $(this);
                if (that.find('input').length > 0) {
                    return;
                }
                var currentText = that.text();

                var $input = $('<input>').val(currentText)
                    .css({
                        'position': 'absolute',
                        top: '0px',
                        left: '0px',
                        width: '489px',
                        height: that.height(),
                        opacity: 0.9,
                        padding: '13.5px'
                    });
                $(this).append($input);

                // Handle outside click
                $(document).click(function (event) {
                    if (!$(event.target).closest('.test').length) {
                        if ($input.val()) {
                            that.text($input.val());

                        }
                        that.find('input').remove();
                        alert($input.val());
                        $.ajax
                        ({
                            type: "POST",
                            url: "update.php",
                            data: {NAME: $input.val(), ID: id},
                            dataType: "JSON",
                            cache: false,
                            success: function (e) {
                                var updateName = e;
                                var js = JSON.parse(e);
                                console.log(e);
                            }
                        });

                    }
                });

                var updateText = $input.val();
                //var id = $(event.target).closest('li').val();
                var id = $(this).parent().closest('li').attr('value');
                var dataID = 'ID=' + id;
                console.log(dataID);

            });

            $(document).on("click", ".test", function () {
                $(this).attr('contentEditable', true);
            });
            $("li > div.donetab").click(function () {
                $(this).parent().find('.test').wrap("<strike>");
                $(this).parent().find('.test').animate({opacity: 0.5});
            });
            function sayHello(name) {
                //for(var cpt = 0; cpt <= inputs.length; cpt++) {
                $("ul#list").append('<li color="1" class="colorBlue" rel="1" id="' + inputs.length + '"><span id="' + inputs.length + 'listitem" title="Double-click to edit..." style="opacity: 1;">' + name + '</span><div class="draggertab tab"></div><div class="colortab tab" onclick="myFunction(this)"></div><div class="deletetab tab" style="width: 44px; display: block; right: -64px;"></div><div class="donetab tab"></div></li>');
                //count++;
                //alert(count);

            }

        });

        $(function () {
            $("ul#list").sortable({
                update: function (event, ui) {
                    var a = $(this).sortable('toArray', {attribute: "value"});
                    var updateText
                    console.log(a);
//                    console.log(order);
                    $.ajax({
                        data: {items: a},
                        type: 'POST',
                        url: 'listSort.php',
                        success: function (e) {
                            console.log(e);
                        }
                    });
                }
            }).disableSelection();

        });

        //        function colorChange() {
        $(function () {

        });
        //        }
    </script>
</head>
<body>
<div id="page-wrap">
    <div id="header">
        <h1><a href="">PHP Sample Test App</a></h1>
    </div>
    <div id="main">
        <noscript>This site just doesn't work, period, without JavaScript</noscript>
        <ul id="list" class="ui-sortable">
            <?php

            $count = 0;
            try {
                $items = Items::asc();
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            foreach ($items as $item):
                ?>
                <li color="1" class="colorBlue" rel="1" id="<?php echo $count ?>" value="<?php echo $item->id; ?>">
                    <span class="test" id="<?php echo $count ?>listitem" title="Double-click to edit..."
                          style="opacity: 1;"><?php echo $item->name; ?></span>
                    <div class="draggertab tab"></div>
                    <div class="colortab tab" onClick="myFunction(this)"></div>
                    <div class="deletetab tab" id="delete" style="width: 44px; display: block; right: -64px;">
                    </div>
                    <div class="donetab tab"></div>
                </li>
                <?php
                $count++;
            endforeach;
            ?>
        </ul>

        <br/>

        <form id="add-new" method="post">
            <input type="text" name="record" id="new-list-item-text"/>
            <input type="button" name='action' id="add-new-submit" value="Add" class="button"/>
        </form>

        <div id="try"></div>
        <div class="clear"></div>
    </div>
</div>
<script>
    function myFunction(x) {

        // var len = $(this).inputs.length;
        // console.log(len);
        spanID = $(x).parent("li").attr("id");
        //alert(spanID);
        //alert(this.id);
    }

</script>
</body>
</html>
