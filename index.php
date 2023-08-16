<?php
if (!empty($_REQUEST['Sender'])):
    $sender = $_REQUEST['Sender'];
    $layout = file_get_contents('./layout.html', FILE_USE_INCLUDE_PATH);

    foreach ($sender as $key => $value) {
        $key = strtoupper($key);
        $start_if = strpos($layout, '[[IF-' . $key . ']]');
        $end_if = strpos($layout, '[[ENDIF-' . $key . ']]');
        $length = strlen('[[ENDIF-' . $key . ']]');

        if (!empty($value)) {
           
            $layout = str_replace('[[IF-' . $key . ']]', '', $layout);
            $layout = str_replace('[[ENDIF-' . $key . ']]', '', $layout);
            $layout = str_replace('[[' . $key . ']]', $value, $layout);
        } elseif (is_numeric($start_if)) {
           
            $layout = str_replace(substr($layout, $start_if, $end_if - $start_if + $length), '', $layout);
        } else {
           
            $layout = str_replace('[[' . $key . ']]', '', $layout);
        }
    }

  
    $layout = preg_replace("/\[\[IF-(.*?)\]\]([\s\S]*?)\[\[ENDIF-(.*?)\]\]/u", "", $layout);

    if (!empty($_REQUEST['download'])) {
        header('Content-Description: File Transfer');
        header('Content-Type: text/html');
        header('Content-Disposition: attachment; filename=signature.html');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
    }

    echo $layout;
else: ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Lucas Machado">

    <title>Signature Generator</title>

   
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">

    
    <style type="text/css">
     

        html,
        body {
            height: 100%;
       
        }

      
        #wrap {
            min-height: 100%;
            height: auto !important;
            height: 100%;
            margin: 0 auto -60px;
            padding: 0 0 60px;
        }

        #footer {
            height: 60px;
            background-color: #f5f5f5;
        }

        #wrap > .container {
            padding: 60px 15px 0;
        }

        .container .credit {
            margin: 20px 0;
        }

        #footer > .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        code {
            font-size: 80%;
        }

        .navbar-default {
            background-color: #ffffff;

        }
    </style>

</head>

<body>


<div id="wrap" class="pinnacle-wrapper">
    <!-- scrolling but Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                  
                </a>

            </div>
        </div>
    </div>
 
    <div class="container">
        <div class="page-header">
            <h1 class="main-header"> Signature Generator</h1>
        </div>
        <form role="form" method="post" target="preview" id="form">
            <div class="row">
                <!-- Personal information -->
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label for="Name">First Name</label>
                        <input type="text" class="form-control" id="Name" name="Sender[name]"
                               placeholder="First name">
                    </div>
                    <div class="form-group">
                        <label for="LName">Last Name</label>
                        <input type="text" class="form-control" id="Name" name="Sender[Lname]"
                               placeholder="Last name">
                    </div>
                    
                    <div class="form-group">
                        <label for="Phone">Phone Number</label>
                        <input type="number" minlength="5" maxlength="10" class="form-control"  id="personalPhone" name="Sender[phone]"
                               placeholder="96895172032">
                    </div>

                    <div class="form-group">
                        <label for="dept"> Department </label>
                        <input type="text" class="form-control" id="dept" name="Sender[dept]"
                               placeholder="HR" value="">
                    </div>
                </div>

                
                <div class="col-sm-6 col-md-6">

                    
                    <div class="form-group">
                        <label for="position"> Job Role</label>
                        <input type="text" class="form-control" id="Phone" name="Sender[position]"
                               placeholder="Web Developer" value="">
                    </div>

                    <div class="form-group">
                        <label for="web"> Website URL/LINK</label>
                        <input type="text" class="form-control" id="web" name="Sender[web]"
                               placeholder="http://testwebsite.com" value="">
                    </div>
                    <div class="form-group">
                        <label for="webs"> Social Media Link</label>
                        <input type="text" class="form-control" id="webs" name="Sender[webs]"
                               placeholder="http://testwebsite.com" value="">
                    </div>

                    

                </div>
            </div>

                
           
            <button id="preview" type="submit" class="btn btn-default">Preview</button>
            <button id="download" class="btn btn-default">Download</button>
            <input type="hidden" name="download" id="will-download" value="">
        </form>
    </div>
    <div class="container">
        <!-- preview box -->
        <iframe src="about:blank" name="preview" width="100%" height="200"></iframe>
    </div>
</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {

        $("#download").bind("click", function () {
            $('#will-download').val('true');
            $('#form').removeAttr('target').submit();
        });

        $("#preview").bind("click", function () {
            $('#will-download').val('');
            $('#form').attr('target', 'preview');
        });

        
        $("input.phone").keyup(function () {
            $(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d)+$/, "($1) $2-$3"));
        });

    });

</script>
</body>
</html>
<?php endif;