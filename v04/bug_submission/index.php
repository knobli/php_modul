<?php
require_once('recaptchalib.php');
define("PUBLIC_KEY", "6LeVbvsSAAAAALdj3JYARThMfdMXeSpB0q5nEMdf");
/**
 * Created by PhpStorm.
 * User: knobli
 * Date: 04.10.2014
 * Time: 09:11
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Submit us your Bug!</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css" type="text/css" media="all"/>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript">
        // ref: http://diveintohtml5.org/detect.html
        function supports_input_placeholder() {
            var i = document.createElement('input');
            return 'placeholder' in i;
        }

        if (!supports_input_placeholder()) {
            var fields = document.getElementsByTagName('INPUT');
            for (var i = 0; i < fields.length; i++) {
                if (fields[i].hasAttribute('placeholder')) {
                    fields[i].defaultValue = fields[i].getAttribute('placeholder');
                    fields[i].onfocus = function () {
                        if (this.value == this.defaultValue) this.value = '';
                    }
                    fields[i].onblur = function () {
                        if (this.value == '') this.value = this.defaultValue;
                    }
                }
            }
        }
    </script>
</head>
<body>

<h2>Bitte melde deinen Bug mit diesem Formular</h2>

<form class="form" action="filebug.php" method="POST" enctype="multipart/form-data">

    <p class="name">
        <input type="text" name="name" id="name" placeholder="John Doe" required/>
        <label for="name">Name</label>
    </p>

    <p class="password">
        <input type="password" name="password" id="password" required/>
        <label for="password">Passwort</label>
    </p>

    <p class="email">
        <input type="email" name="email" id="email" placeholder="mail@example.com" required/>
        <label for="email">Email</label>
    </p>

    <p class="web">
        <input type="url" name="web" id="web" placeholder="www.example.com" required/>
        <label for="web">Betreffende Website</label>
    </p>

    <p class="date">
        <input type="datetime" name="date" id="date" placeholder="Please specify a date and time" required/>
        <label for="date">Datum</label>
    </p>

    <p class="prio">
        <input type="range" name="prio" id="prio" min="1" max="10" value="1" oninput="printPrioValue(this.value)"
               onchange="printPrioValue(this.value)" required>
        <label for="prio">Priorität:</label> <span id="prioValue"></span>
    </p>

    <p class="bugtype">
        <select name="bugtype" id="bugtype" required>
            <option>A</option>
            <option>B</option>
            <option>C</option>
        </select>
        <label for="bugtype">Fehlertyp</label>
    </p>

    <p class="text">
        <textarea name="text" placeholder="Fehlerreport" required/></textarea>
    </p>

    <p class="reproducible">
    <span class="radiogroup">
        <input type="radio" name="reproducible" value="0" checked/> Nein
        <input type="radio" name="reproducible" value="1"/> Ja
    </span>
        <label for="reproducible">Reproduzierbar</label>
    </p>

    <p class="picture">
        <input type="file" name="picture" id="picture" required/>
        <label for="picture">Bild</label>
    </p>

    <p class="recall">
        <input type="checkbox" name="recall" id="recall"/>
        <label for="recall">Rückruf</label>
    </p>

    <p class="text">
        <?= recaptcha_get_html(PUBLIC_KEY) ?>
    </p>

    <p class="submit">
        <input type="submit" value="Senden"/>
    </p>
</form>
<script>
    function printPrioValue(value) {
        document.getElementById("prioValue").innerHTML = value;
    }

    function checkMailAddress(mailAddress){
        var pattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
        return mailAddress.match(pattern);
    }

    function checkUrl(url){
        var pattern = /^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)/;
        return url.match(pattern);
    }

    printPrioValue(document.getElementById('prio').value);

    $(function () {


        function supports_input_required() {
            return 'required' in document.createElement('input');
        }

        if (!supports_input_required()) {
            $('[required]').each(function () {
                // this
                var self = $(this)
                // swap attribute for class
                self.removeAttr('required').addClass('required')
                // append an error message
                self.parent().append('<span class="form-error">Required</span>')
            })
        }

        // submit the form
        $('.form').on('submit', function (e) {
            // loop through class name required
            $('.required').each(function () {
                // this
                var self = $(this)
                // check shorthand if statement for input[type] detection
                var checked = (self.is(':checkbox') || self.is(':radio'))
                    ? self.is(':not(:checked)') && $('input[name=' + self.attr('name') + ']:checked').length === 0
                    : false
                // run the empty/not:checked test
                if (self.val() === '' || checked) {
                    // show error if the values are empty still (or re-emptied)
                    // this will fire after it's already been checked once
                    self.siblings('.form-error').show()
                    // stop form submitting
                    e.preventDefault()
                    // if it's passed the check
                } else {
                    // hide the error
                    self.siblings('.form-error').hide()
                }
            });

            if (!supports_input_required()) {
                if(checkMailAddress($("#mail").val())){
                    alert("Mail Adresse nicht korrekt");
                    e.preventDefault();
                }

                if(checkUrl($("#web").val())){
                    alert("Web Seite nicht korrekt");
                    e.preventDefault();
                }
            }


        });

        if (!supports_input_required()) {
            // key change on all form inputs
            $('input, textarea', '.form').on('blur change', function () {
                // this
                var self = $(this)
                // check shorthand if statement for input[type] detection
                var checked = (self.is(':checkbox') || self.is(':radio'))
                    ? self.is(':not(:checked)') && $('input[name=' + self.attr('name') + ']:checked').length === 0
                    : false
                // if empty on change, i.e. if data is removed
                if (self.val() === '' || checked) {
                    // show/keep the error in view
                    self.siblings('.form-error').show()
                    // if there's a value or checked
                } else {
                    // hide the error
                    self.siblings('.form-error').hide()

                }

            })
        }
    });
</script>
</body>
</html>
