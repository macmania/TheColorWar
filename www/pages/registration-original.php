<?

config()->title = "The Color War";
config()->push('js', 'js/jquery.cookie.js');
config()->push('js', 'js/registration.js');
config()->push('js', 'js/jquery.maskedinput.min.js');

config()->push('css', 'css/registration.css');

if (isset($_POST['submit']) && $_POST['submit'] == 'true') {
    $variables = array(
        "first-name",
        "last-name",
        "dob",
        "email",
        "phone",
        "marketing-source",
        "marketing-reason",
        "soak",
        "splash",
        "sprinkle");

    $list = array();
    foreach ($variables as $key => $var) {
        $variables[$key] = isset($_POST[$var]) ? $_POST[$var] : '';
    }
    writeToCSV("data/data.csv", $variables);
    die("Wrote " . print_r($variables, true));
}



printHeader();


function writeToFile($file, $string, $mode = "a+") {
    $fh = fopen($file, "a+");
    if ($fh) {
        flock($fh, LOCK_EX);
        fwrite($fh, $string);
        fflush($fh);
        flock($fh, LOCK_UN);
        return true;
    } else {
        fclose($fh);
        return false;
    }
}

function writeToCSV($file, $items) {
    $fh = fopen($file, "a+");
    if ($fh) {
        flock($fh, LOCK_EX);
        fputcsv($fh, $items);
        fflush($fh);
        flock($fh, LOCK_UN);
        return true;
    } else {
        fclose($fh);
        return false;
    }
}

function getPriceString($original, $discount) {
    if ($discount) {
        return '<em class="fake-price"><s></s>$' . $original . '</em><em class="price">$' . $discount . '</em>';
    } else {
        return '<em class="price">$' . $original . '</em>';
    }
}

?>
<div data-stage="1" class="content-box split products">
    <form class="left"> 
        <div class="product" data-price="10" data-title="T-Shirt" name="tshirt">
            <div class="details">
                <h4>T-Shirt - <em class="price">$10</em></h4>
                <div class="description">
                    A T-Shirt you can wear on the day of and after the event. If you want the colors to stick after the event try spraying with vinegar and ironing before washing!
                </div>
                <div>
                    Take a peek at the shirts: 
                    &nbsp;
                    <a target="_blank" rel="clearbox[gallery=Shirts,,comment=]" href="images/assets/shirts-large-white.jpg">White</a>
                    &nbsp;
                    <a target="_blank" rel="clearbox[gallery=Shirts,,comment=]" href="images/assets/shirts-large-grey.jpg">Grey</a>
                </div>
                <select class="option">
                    <option value="Men">Men</option>
                    <option value="Women">Women</option>
                </select>
                <select class="option">
                    <option value="Small">Small</option>
                    <option value="Medium">Medium</option>
                    <option value="Large">Large</option>
                    <option value="X-Large">X-Large</option>
                    <option value="XX-Large" data-extra="2">XX-Large (+$2)</option>
                </select>
                <select class="option">
                    <option value="Grey">Grey</option>
                    <option value="White">White</option>
                </select>
            </div>
            <div class="modifier">
                <a class="small button add-cart">Add to Cart</a>
            </div>
            <div class="clear"></div>
        </div>
        <?
        if (config()->discountText) {
            ?>
        <div class="orange" style="text-align: center; margin: 10px 0">
            <?=config()->discountText?>
        </div>
            <?
        }
        ?>

        <div data-price="<?=choose(config()->soakDiscountedPrice, config()->soakPrice)?>" data-title="Soak Package" class="product shade package" name="soak">
            <div class="details">
                <h4>Soak - <?=getPriceString(config()->soakPrice, config()->soakDiscountedPrice)?></em></h4>
                <span class="description">Contains <strong>5</strong> packets of color! In it for the long haul? You'll be an unstoppable force when it comes to color day.</span>
            </div>
            <div class="modifier">
                <a class="small button add-cart">Add to Cart</a>
            </div>
            <div class="clear"></div>
        </div>

        <div data-price="<?=choose(config()->splashDiscountedPrice, config()->splashPrice)?>" data-title="Splash Package" class="product shade package" name="splash">
            <div class="details">
                <h4>Splash - <?=getPriceString(config()->splashPrice, config()->splashDiscountedPrice)?></em></h4>
                <span class="description">Contains <strong>2</strong> packets of color! Have enough to get several friends and then some!</span>
            </div>
            <div class="modifier">
                <a class="small button add-cart">Add to Cart</a>
            </div>
            <div class="clear"></div>
        </div>

        <div data-price="0" data-title="Sprinkle Package" class="product shade small package" name="sprinkle" >
            <div class="details">
                <h4>Sprinkle - <em class="price">Free</em></h4>
                <span class="description">Grants you entry to the event and a single color packet while supplies last.</span>
            </div>
            <div class="modifier">
                <a class="small button add-cart">Add to Cart</a>
            </div>
            <div class="clear"></div>
        </div>
        
        <br />
    </form>
    <div class="right">
        <h2>Your total: <span class="orange total-amount">$0.00</span></h2>
        <div style="margin-bottom: 5px">
            Update individual quantities below:
        </div>
        <div class="cart"></div>
        <div style="margin-bottom:5px">
            <strong>Note: </strong>You'll need to print and sign a waiver in order to enter the event. The waiver will be posted here and emailed to you in the coming weeks!
        </div>
        <!--
        <div style="margin-bottom:5px">Before moving on you must print and sign a waiver. Keep in mind you need to bring this waiver to enter the event!</div>
        <div style="text-align:center">
            <a class="small orange button waiver" target="_blank" rel="clearbox[gallery=Gallery,,comment=]" href="assets/waiver.pdf" title="Once you have printed the waiver click the close button to the right">Print and sign waiver</a>
        </div>
        <br />
        <br />
        -->
        <a class="button next" data-error="You need to print and sign the waiver!">Next Step</a>
    </div>
    <div class="clear"></div>
</div>
<div data-stage="2" class="content-box split user-details">
    <h2>Just to get to know you a little better..</h2>
    <form class="left">
        <div class="pair">
            <label class="required">First Name</label>
            <input required="true" type="text" name="first-name" />
        </div>
        <div class="pair">
            <label class="required">Last Name</label>
            <input required="true" type="text" name="last-name" />
        </div>
        <div class="pair">
            <label class="required">Gender</label>
            <input required="true" name="gender" value="m" type="radio" />Male
            <span style="padding:0 10px;"></span>
            <input required="true" name="gender" value="f" type="radio" />Female
        </div>
        <div class="pair">
            <label class="required">Date of Birth</label>
            <input name="dob" type="text" />
        </div>
        <div class="pair">
            <label class="required">Email Address</label>
            <input name="email" type="text" required="true" />
            <div class="descriptor">
                We'll never spam or share your email address with anybody. It'll strictly be used to keep you updated!
            </div>
        </div>
        <div class="pair">
            <label>Phone Number</label>
            <input name="phone" type="text" required="false" />
            <div class="descriptor">
                If you would like to receive SMS updates then enter your phone number above.
            </div>
        </div>
    </form>
    <div class="right">
        <div style="height: 30px"></div>
        Make sure to enter everything in correctly here otherwise you might have issues getting in!
        <br />
        <br />
        <a class="button next">Next Step</a>
    </div>
    <div class="clear"></div>
</div>
<div data-stage="3" class="content-box split marketing-questions">
    <h2>Just two more questions!</h2>
    <form class="left">
        <div class="pair" style="margin-bottom: 20px">
            <label>How did you hear about us?</label>
            <select required="true" name="marketing-source">
                <option value="">Select an option</option>
                <option value="fb-event">The original Facebook event</option>
                <option value="fb-page">The official Facebook page</option>
                <option value="friend">A friend</option>
                <option value="campus-advertising">Advertising on campus</option>
                <option value="newspaper">Newspaper</option>
            </select>
        </div>

        <div class="pair">
            <label>What made you want to attend most?</label>
            <select required="true" name="marketing-reason">
                <option value="">Select an option</option>
                <option value="good-time">Just looks like a good time!</option>
                <option value="good-cause">It's for a good cause</option>
                <option value="missed-crd">I missed out on Color Me Rad :(</option>
                <option value="loved-crd">I LOVED Color Me Rad</option>
                <option value="forced-by-friends">I was forced by my friends</option>
            </select>
        </div>
        <input type="hidden" name="submit" value="true" />
    </form>
    <div class="right checkout">
        After double checking that everything is filled out correctly you can continue to the checkout page! If you only signed up for the free membership you'll be redirected a completion page.
        <br />
        <br />
        Your total is <span class="orange total-amount">$0.00</span>
        <br />
        <br />
        <div style="text-align:center">
            <a data-error="Hold on! Doing some work behind the scenes, it'll only take a second." class="button next">Enter Payment Details</a>
            <small style="display:block">(You'll be redirected to Google Wallet to complete the payment)</small>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?

printFooter();

?>