<?

config()->title = "Contact Us";

config()->push('js', '/js/contact.js');


printHeader();

function cleanHeader($item) {
    return str_replace("\\n", "", str_replace("\\r", "", $item));
}

if (isset($_POST['submit']) && !empty($_SERVER['HTTP_USER_AGENT'])) {
    $name = cleanHeader($_POST['name']);
    $email = cleanHeader($_POST['email']);
    $message = $_POST['message'];

    $emailSubject = "Contact form submitted by " . $name;
    $emailMessage = "You can hit reply to this email to respond to " . $name . " (" . $email . ")\n" . 
            "----------------------------\n" . 
            $message . "\n";
    $emailHeaders = "Reply-To: <" . $email . ">";

    if (mail(config()->email, $emailSubject, $emailMessage, $emailHeaders)) {
        ?>
        <div class="success_bar">
            Your message has been sent successfully, we'll be back in touch with you shortly.
        </div>
        <?
    } else {
        ?>
        <div class="error_bar">
            We were unable to send your message, either try again later or contact us directly at 
            <a href="mailto:<?=config()->email?>"><?=config()->email?></a>. Sorry for the inconvenience!
        </div>
        <?
    }
}

?>
            <div class="content-box split">
                <h2>How to get in touch</h2>
                <form class="left" method="post" action="/contact" id="contact-form">
                    <div class="pair">
                        <label>Name</label>
                        <input name="name" type="text">
                    </div>
                    <div class="pair">
                        <label>Email</label>
                        <input name="email" type="text">
                    </div>
                    <div class="pair">
                        <label>Message</label>
                        <textarea rows=4 name="message"></textarea>
                    </div>
                    <div class="pair">
                        <label></label>
                        <input type="submit" name="submit" value="Submit" class="button" />
                    </div>
                </form>
                <div class="right">
                    <div>
                        If you have any questions about The Color War that are not already answered in our FAQ, send us an email, a message on Facebook, or Tweet us on Twitter!
                        <br />
                        <br />
                        You can email us at <a href="mailto:<?=config()->email?>"><?=config()->email?></a>
                    </div>
                </div>
                <div class="clear"></div>
            </div>

<?

printFooter();

?>