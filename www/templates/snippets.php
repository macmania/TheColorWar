<?


function printBarebonesHeader($background = true) {
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head>
        <script type='text/javascript'>
            window.Muscula = { settings:{
                logId:"97dc5955-7889-49cf-9361-fe9614dabca2", suppressErrors: false, branding: 'none'
            }};
            (function () {
                var m = document.createElement('script'); m.type = 'text/javascript'; m.async = true;
                m.src = (window.location.protocol == 'https:' ? 'https:' : 'http:') +
                    '//musculahq.appspot.com/Muscula.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(m, s);
                window.Muscula.run=function(c){eval(c);window.Muscula.run=function(){};};
                window.Muscula.errors=[];window.onerror=function(){window.Muscula.errors.push(arguments);
                return window.Muscula.settings.suppressErrors===undefined;}
            })();
        </script>
        <script type="text/javascript">
          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-39417899-1']);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();

        </script>
        <!-- start Mixpanel -->
        <script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f);b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==
            typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,
            e,d])};b.__SV=1.2}})(document,window.mixpanel||[]);
            mixpanel.init("0b797547dfd30497449e5a10cedc4194");
        </script>
        <!-- end Mixpanel -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta property="og:site_name" content="The Color War" />
        <meta property="fb:admins" content="525448232"/>
        <meta itemprop="name" content="The Color War">
        <meta itemprop="description" content="The Color War is a collective effort to unite the community through a colorful celebration
            while raising money to build a school in Honduras through Students Helping Honduras, The Indian Student Association and The Society of Indian Americans!">
        <meta property="og:image" content="http://thecolorwarvt.com/images/logo.jpg" />
        <meta property="og:title" content="Register For The Color War!" />
        <meta property="og:description" content="The Color War is a collective effort to unite the community through a colorful celebration
            while raising money to build a school in Honduras through Students Helping Honduras, The Indian Student Association and The 
            Society of American Indians!" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="http://thecolorwarvt.com/"/>
        <link rel="image_src" href="/images/logo.jpg"/>
        <title><?= config()->title ?></title>
        <?
        config()->each('css', function($key, $elem) {
            ?>
            <link href="<?=$elem ?>" rel="stylesheet" type="text/css" />
            <?
        });
        ?>
        <?
        config()->each('js', function($key, $elem) {
            ?>
        <script src="<?=$elem ?>" type="text/javascript"></script>
            <?
        });
        ?>
        <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    </head>
    <body <?=$background ? "" : "class='nobackground'" ?>>
        <?
}

function printBarebonesFooter() {
    ?>
    </body>
</html>
    <?
}

function printHeader() {
    printBarebonesHeader(true);
    ?>
        <div id="wrapper">
            <div class="social">
                <a href="https://www.facebook.com/TheColorWar" target="_blank">
                    <img src="/images/icons/fb.png" alt="Facebook" name="FB" width="50" height="50" id="FB" />
                </a>
                <a href="https://www.twitter.com/TheColorWar" target="_blank">
                    <img src="/images/icons/twitter.png" width="50" height="50" alt="Twitter" />
                </a>
                <a href="https://www.youtube.com/user/dudedudedudewoah1" target="_blank">
                    <img src="/images/icons/youtube.png" width="50" height="50" alt="Youtube" />
                </a>
            </div>
            <div class="navbar">
                <div class="links">
                    <?
                    config()->each('pages', function($key, $val) {
                        ?>
                        <a class="<?=$val?>" href="/<?=$val?>"><?=$key?></a>
                        <?
                    });
                    ?>
                </div>
            </div>
    <?
    $flash = flash();
    if ($flash) {
        ?>
            <div class="<?=$flash[0]?>_bar">
                <?=$flash[1]?>
            </div>
        <?
    }
}

function printFooter($extra = false) {
    ?>
        <div class="content-box split">
            <div class="left">
                <div>The Color War</div>
                <div class="blue"><?=config()->credits?></div>
            </div>
            <div class="right" style="text-align:right;">
                <div><?
                config()->each('pages', function($key, $val) {
                    ?>
                    <a class="<?=$val?>" href="/<?=$val?>"><?=$key?></a> |
                    <?
                })
                ?>
                    <a target="_blank" rel="clearbox[gallery=privacy,,comment=]" href="privacy" title="Privacy Policy">Privacy Policy</a>
                </div>
                <?=($extra ? $extra : "")?>
            </div>
            <div class="clear"></div>
        </div>
    <?
    printBarebonesFooter();
}

?>