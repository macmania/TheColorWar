<?

config()->title = "The Color War";
config()->push('js', '/js/jquery.cookie.js');
// config()->push('js', '/js/sisyphus.min.js');
// config()->push('js', '/js/jquery.dumbformstate.min.js');
config()->push('js', '/js/jquery.maskedinput.min.js');
config()->push('js', '/js/registration.js');

config()->push('css', '/css/registration.css');

$defaultPromo = config()->promos['default'];
$promoCode = isset($_REQUEST['promo']) ? strtolower($_REQUEST['promo']) : false;
$invalidPromo = !isset(config()->promos[$promoCode]);
$promo = $invalidPromo ? 
    $defaultPromo :
    array_merge($defaultPromo, config()->promos[$promoCode]);

if ($promo['message'])
    config()->discountText = $promo['message'];
if ($promo['soakDiscount'])
    config()->soakDiscountedPrice = config()->soakPrice - $promo['soakDiscount'];
if ($promo['splashDiscount'])
    config()->splashDiscountedPrice = config()->splashPrice - $promo['splashDiscount'];
if ($promo['shirtDiscount'])
    config()->shirtDiscountedPrice = config()->shirtPrice - $promo['shirtDiscount'];


if (isset($_POST['submit']) && $_POST['submit'] == 'cart') {

    require "utils/google/googlecart.php";
    require "utils/google/googleitem.php";

    $registration = array(
        'first_name' => $_POST['first-name'],
        'last_name' => $_POST['last-name'],
        'gender' => $_POST['gender'],
        'date' => date("Y-m-d H:i:s", time()),
        'dob' => $_POST['dob'],
        'email' => $_POST['email'],
        //'phone' => $_POST['phone'],
        //'source' => $_POST['marketing-source'],
        //'reason' => $_POST['marketing-reason'],
        'state' => '',
        'soak' => 0,
        'splash' => 0,
        'sprinkle' => 0,
        'other' => '',
        'total' => 0,
        'extra_packets' => 0
    );

    $_SESSION['name'] = $_POST['first-name'];

    $cart = new GoogleCart(config()->googleMerchantId, config()->googleMerchantKey, 'checkout-shopping-cart', 'USD');
    $other = array();
    $donation = floatval($_POST['donation-amount']);
    $total = 0;
    $discount = 0;

    for ($i = 1; ; $i++) {
        // Check if all the required fields are present
        $fields = array("name", "description", "price", "currency", "quantity", "merchant_id", "identifier");
        $break = false;
        foreach ($fields as $field) {
            if (!isset($_POST['item_' . $field . '_' . $i])) {
                $break = true; break;
            }
        }
        // Break/continue otherwise
        if ($break) break;
        if ($_POST["item_quantity_" . $i] <= 0) continue;

        $identifier = trim($_POST['item_identifier_' . $i]);
        $name = trim($_POST['item_name_' . $i]);
        $description = trim($_POST['item_description_' . $i]);
        $quantity = intval(trim($_POST['item_quantity_' . $i]));
        $price = floatval(trim($_POST['item_price_' . $i]));

        // Create a new google item for the cart
        $item = new GoogleItem($name, $description, $quantity, $price);
        $cart->AddItem($item);

        $total += $quantity * $price;

        if ($identifier == "soak") {
            $registration['soak']++;
            $registration['extra_packets'] += $promo['soakExtraPackets'];
        } else if ($identifier == "splash") {
            $registration['splash']++;
            $registration['extra_packets'] += $promo['splashExtraPackets'];
        } else if ($identifier == "sprinkle") {
            $registration['sprinkle']++;
            $registration['extra_packets'] += $promo['sprinkleExtraPackets'];
        } else {
            array_push($other, array(
                'id' => $identifier,
                'quantity' => $quantity,
                'name' => $name,
            ));
        }
    }

    if ($registration['extra_packets']) {
        $item = new GoogleItem(
            'Extra Color Packets',
            'The more color packets the more fun!',
            $registration['extra_packets'],
            '0.00');
        $cart->AddItem($item);
    }

    if ($promo['discountPercent']) {
        $disc = $promo['discountPercent'] / 100 * $total;
        $item = new GoogleItem($promo['discountPercent'] . '% off (' . $_REQUEST['promo'] . ')', "", 1, -$disc);
        $cart->AddItem($item);
        $discount += $disc;
    }
    if ($promo['discountAbsolute']) {
        $disc = $promo['discountAbsolute'];
        $item = new GoogleItem($promo['discountAbsolute'] . '$ off (' . $_REQUEST['promo'] . ')', "", 1, -$disc);
        $cart->AddItem($item);
        $discount += $disc;
    }

    if ($donation > 0) {
        $total += $donation;
        $item = new GoogleItem("Donation", "You're a kind, kind hearted soul.", 1, $donation);
        $cart->AddItem($item);
    }

    $registration['promo'] = isset($_POST['promo']) ? $_POST['promo'] : NULL;
    $registration['other'] = json_encode($other);
    $registration['donation'] = $donation;
    $registration['discount'] = $discount;

    DB::insert('registrations', $registration);

    $registrationId = DB::insertId();

    if ($total > 0.30) {
        $cart->SetContinueShoppingUrl("http://thecolorwarvt.com/about?status=complete&flash=1");
        $cart->SetMerchantPrivateData($registrationId);
        $details = $cart->CheckoutDetails();
        if (isset($details['serial'])) {
            // Cart submitted successfully!

            DB::update('registrations', array(
                'cart_url' => $details['redirect']
            ), 'id=%d', $registrationId);

            die(json_encode(array(
                "status" => "redirect",
                "url" => $details['redirect']
            )));
        } else {
            // There was an error from the server
            die(json_encode(array(
                'status' => 'error',
                'error' => 'There was an error, please try again later.'
            )));
        }
    } else {
        flash('success', 'You\'ve registered successfully! We\'ll be in touch shortly with more details on the event.');
        die(json_encode(array(
            'status' => 'redirect',
            'url' => '/about?status=complete'
        )));
    }

}

printHeader();


function getPriceString($original, $discount) {
    if ($discount && $discount != $original) {
        return '<span class="discount"><em class="fake-price"><s></s>$' . $original . '</em><em class="price">$' . $discount . '</em></span>';
    } else {
        return '<em class="price">$' . $original . '</em>';
    }
}

function getNumberString($original, $extra) {
    if ($extra > 0) {
        return '<span class="discount"><em class="fake-number"><s></s>' . $original . '</em><em class="number">' . ($original + $extra) . '</em></span>';
    } else {
        return '<em class="number">' . $original . '</em>';
    }
}

if (config()->registrationNotice) {
?>
<div class="notice_bar">
    <?=config()->registrationNotice?>
</div>
<?
}

$promoText = false;
if (!$invalidPromo && $promoCode) {
    $promoList = array();
    $promos = array(
        'soakExtraPackets' => '%d extra color packet(s) when getting the Soak package',
        'splashExtraPackets' => '%d extra color packet(s) when getting the Splash package',
        'sprinkleExtraPackets' => '%d extra color packet(s) when getting the Sprinkle package',
        'splashDiscount' => '$%.2f off the Splash Package',
        'soakDiscount' => '$%.2f off the Soak Package',
        'shirtDiscount' => '$%.2f off all shirts',
        'discountPercent' => "%d%% off your entire order",
        'discountAbsolute' => '$%.2f off your entire order',
    );
    foreach ($promos as $key => $format) {
        if ($promo[$key] > 0) {
            array_push($promoList, sprintf($format, $promo[$key]));
        }
    }
    if (count($promoList) && $promo['message']) {
        $promoText = '
            <div class="success_bar bold">
                <div class="centered white" style="font-size: 110%">' . $promo['message'] . '</div>';
        
        // $promoText .= '<ul>';
        // foreach ($promoList as $promotion) {
        //     $promoText .= '<li>' . $promotion . '</li>';
        // }
        // $promoText .= '</ul>';
        
        $promoText .= '</div>';
    }
} else if ($promoCode) {
    $promoText = '
        <div class="notice_bar bold">
            Invalid promo code: <strong>' . $promoCode . '</strong>
        </div>';
}
?>
    <?=$promoText?>
<div data-stage="1" class="content-box split products">
    <form class="left"> 
        <?
        if (isset($_GET['promo'])) {
            ?>
            <input type="hidden" name="promo" value="<?=$_GET['promo']?>" />
            <?
        }
        ?>
        <div data-price="0" data-title="Sprinkle Package" class="product shade small package" name="sprinkle" >
            <div class="details">
                <h4>Sprinkle - <em class="price">Free</em></h4>
                <span class="description">Grants you entry to the event and <?=getNumberString(config()->sprinklePackets, $promo['sprinkleExtraPackets'])?> color packet at the event on a first come first served basis, while supplies last.</span>
            </div>
            <div class="modifier">
                <!--<a class="small button add-cart">Add to Cart</a>-->
                <a class="small button add-cart disabled" data-error="Registration has ended for 2013.">Add to Cart</a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="product" data-price="<?=choose(config()->shirtDiscountedPrice, config()->shirtPrice)?>" data-title="T-Shirt" name="tshirt">
            <div class="details">
                <h4>T-Shirt - <em class="price"><?=getPriceString(config()->shirtPrice, config()->shirtDiscountedPrice)?></em></h4>
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
                    <option value="XX-Large" data-extra="<?=config()->shirtExtraPrice?>">XX-Large (+$<?=config()->shirtExtraPrice?>)</option>
                </select>
                <select class="option">
                    <option value="Grey">Grey</option>
                    <option value="White">White</option>
                </select>
            </div>
            <div class="modifier">
                <a class="small button add-cart disabled" data-error="Registration has ended for 2013.">Add to Cart</a>
            </div>
            <div class="clear"></div>
        </div>
        <div data-price="<?=choose(config()->soakDiscountedPrice, config()->soakPrice)?>" data-title="Soak Package" class="product shade package" name="soak">
            <div class="details">
                <h4>Soak - <?=getPriceString(config()->soakPrice, config()->soakDiscountedPrice)?></em></h4>
                <span class="description">Contains <strong><?=getNumberString(config()->soakPackets, $promo['soakExtraPackets'])?></strong> packets of color! In it for the long haul? You'll be an unstoppable force when it comes to color day.</span>
            </div>
            <div class="modifier">
                <a class="small button add-cart disabled" data-error="Registration has ended for 2013.">Add to Cart</a>
            </div>
            <div class="clear"></div>
        </div>

        <div data-price="<?=choose(config()->splashDiscountedPrice, config()->splashPrice)?>" data-title="Splash Package" class="product shade package" name="splash">
            <div class="details">
                <h4>Splash - <?=getPriceString(config()->splashPrice, config()->splashDiscountedPrice)?></em></h4>
                <span class="description">Contains <strong><?=getNumberString(config()->splashPackets, $promo['splashExtraPackets'])?></strong> packets of color! Have enough to get several friends and then some!</span>
            </div>
            <div class="modifier">
                <a class="small button add-cart disabled" data-error="Registration has ended for 2013.">Add to Cart</a>
            </div>
            <div class="clear"></div>
        </div>
        
        <br />
    </form>
    <div class="right">
        <h2>Your total: <span class="orange total-amount">$0.00</span></h2>
        <div class="cart">
        <? if ($promo['discountPercent']) {
            ?>
            <div class="cart-item promo" data-discount-type="percent" data-discount-value="<?=$promo['discountPercent']?>">
                <div class="quantity fake"></div>
                <div class="title"><?=$_REQUEST['promo']?> promo code</div>
                <div class="price">%<?=$promo['discountPercent']?> off</div>
                <div class="clear"></div>
            </div>
            <?
        }
        ?>
        <? if ($promo['discountAbsolute']) {
            ?>
            <div class="cart-item promo" data-discount-type="absolute" data-discount-value="<?=$promo['discountAbsolute']?>">
                <div class="quantity fake"></div>
                <div class="title"><?=$_REQUEST['promo']?> promo code</div>
                <div class="price">$<?=$promo['discountAbsolute']?> off</div>
                <div class="clear"></div>
            </div>
            <?
        }
        ?>
        </div>
        <div class="donations">
            <div class="description left">
                Would you like to donate directly to Students Helping Honduras? It's all for a <a href="/about">good cause!</a>
            </div>
            <form class="amount right">
                $ <input name="donation-amount" class="donation-amount" type="text"/>
            </form>
            <div class="clear"></div>
        </div>
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
            <label>Gender</label>
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
        <!--
        <div class="pair">
            <label>Phone Number</label>
            <input name="phone" type="text" required="false" />
            <div class="descriptor">
                If you would like to receive SMS updates then enter your phone number above.
            </div>
        </div>
        -->
    </form>
    <div class="right">
        <!--
        <form class="marketing-questions">
            <div class="pair" style="margin: 20px 0">
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
        </form>
        -->
        <!--
        <div style="color:#999; font-size:11pt;">
            Make sure to enter everything in correctly here otherwise you might have issues getting in!
        </div>
        -->
        <br />
        <a class="button next">Next Step</a>
    </div>
    <div class="clear"></div>
</div>
<div data-stage="3" class="content-box split">
    <div class="left checkout">
        <h3 style="padding-bottom:20px;">Please read and agree to the rules</h3>
        <iframe style="width:440px; height:200px;border:solid 1px #666" src="/rules"></iframe>
        <div class="rules-agreement">
            <input type="checkbox" name="rules" value="1" id="rules" />
            <label for="rules">I have read, and agree to abide by The Color War rules.</label>
        </div>
    </div>
    <div class="right">
        <h3 style="padding-bottom:20px;">Lastly, print and sign the waiver!</h3>
        <div>Make sure you bring the completed waiver to the event or you might not be granted entry. The link below opens in a new window.</div>
        <div class="centered" style="padding: 10px 0;">
            <a class="waiver-button button orange micro">Print Waiver</a>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="content-box" data-stage="3">
    <!--
    Your total is <span class="orange total-amount">$0.00</span>
    -->
    <div class="centered">
        <a class="button next complete-button jumbo" data-error="Please print or save the waiver first!">Complete Registration</a>
        <small class="complete-disclaimer" style="display:block">
            You'll be redirected to Google Wallet to complete the payment.
            <br />
            If you encounter any issues with Google Checkout please clear your cache/cookies and try again.
        </small>
    </div>

</div>
<?

printFooter();

?>