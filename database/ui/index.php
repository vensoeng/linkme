<?php
function ui($text = '',$error= false){ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linkme-UI</title>
    <style>
        
        @import url('https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&display=swap');
        *{
            margin: 0;
            padding: 0;
            text-decoration: none;
            border: none;
            box-sizing: border-box;
            font-family: "Bricolage Grotesque", sans-serif;
            line-height: 1.6;
        }
        .ui-stay{
            --sg-fontbrand: "Bricolage Grotesque", sans-serif;
        }
        .ui-error-active{
            background: #ffeaea !important;
        }
        a.aui{
            cursor: pointer;
            font-family: var(--sg-fontbrand);color: #1876f2c7;
        }
        h2.h2ui{
            font-size: 1.1rem;
            font-family: var(--sg-fontbrand);
        }
    </style>
</head>
<body>
    <div class="ui-main" style="position: relative; display: flex; align-items: center; justify-content: center; min-height: 100vh;">
        <div class="ui-stay" style=" position: absolute;left: 50%; right: 50%; transform: translate(-50%,-50%);width: max-content; max-width: 100%; margin: 0.8rem auto;">
            <div class="<?=$error !== false ? 'ui-error-active' : ''?>" style="max-width: 1000px; margin: 0 0.8rem; background: white; border-radius: 16px; overflow: hidden; list-style: none; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; transition: all ease-in-out 0.3s;">
                <blockquote style="font-size: 1rem; padding: 1rem;">
                    <p style="font-family: var(--sg-fontbrand);"><?=$text?></p>
                </blockquote>
            </div>
        </div>
    </div>
</body>
</html>
<?php
}
?>