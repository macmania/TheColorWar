<?

config()->title = "About Us";

config()->push('css', '/css/about.css');

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'complete' && isset($_GET['flash'])) {
        flash(
            'success', 
            'Thank you for your support! Your order is being finalized and you\'ll receive a confirmation email soon.'
        );
    }
}

printHeader();

if (isset($_GET['status']) && $_GET['status'] == 'complete') {
    ?>
    <script type="text/javascript">
        mixpanel.track('registration_transaction_complete');
        // _trackEvent("Registration", "Transaction Complete", "<?=isset($_SESSION['name']) ? $_SESSION['name'] : ''?>");
    </script>
    <?
}

?>
            <div class="content-box split thirds">
                <h3>At a glance</h3>
                <div class="majority">
                    <ul class="bare ataglance">
                        <li>
                            <label class="fixed em">Where?</label>
                            <div>Corner of Grove Lane &amp; West Campus Drive on Virginia Tech’s campus with <a href="#parking">nearby parking</a></div>
                        </li>
                        <li>
                            <label class="fixed em">When?</label>
                            <div>The 2013 Color War has ended, please check back later for next year's date!</div>
                        </li>
                        <li>
                            <label class="fixed em">Clothes?</label>
                            <div>Wear <span class="white">WHITE</span> but read <a href="#clothing">here</a> for more details.</div>
                        </li>
                        <li>
                            <label class="fixed em">How?</label>
                             <!--<div>Click <a href="/registration">here</a> to register immediately!</div>-->
                             <div>Registration is currently closed. Too see last year's, <a target='_blank' href="http://www.youtube.com/user/dudedudedudewoah1">Click Here</a> </div>
                        </li>
                        <li>
                            <label class="fixed em">What else?</label>
                            <div>Make sure you bring a completed <a target="_blank" href="/waiver">waiver form</a>, otherwise you might not gain entry to the event!</div>
                        </li>
                    </ul>
                </div>
                <div class="right">
                    <div class="sponsors">
                        <div class="sponsor redbull"></div>
                        <div class="sponsor entertainment"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="content-box">
                <h3>The Mission</h3>
                <p>The Color War Collective is a collaboration of three student led organizations and one student at Virginia Tech, Students Helping Honduras, The Society of Indian Americans, and The Indian Student Association. Our objectives are to fundraise money for children in Honduras, bring the community together through our event, and raise awareness for our organizations.</p>
            </div>
            <div class="content-box orgs split thirds">
                <div class="left">
                    <h2>SIA</h2>
                    <h4>Society of Indian Americans</h4>
                    <p>The Society of Indian Americans (SIA) is a governing and programming body which consists of students who have an interest in the Indian and South Asian culture and in meeting other students who share the same interest. SIA also strives to promote the South Asian culture on campus. The association works to provide a substantial identity for the Indian Culture at Virginia Tech. Alongside our cultural representation, the society also hosts an array of programs, dances, cultural-evenings, intramurals, socials and community service gatherings in a mission to make its members feel at home and united.</p>
                </div>
                <div class="middle">
                    <h2>ISA</h2>
                    <h4>The Indian Students Association</h4>
                    <p>The Indian Students Association (ISA) at Virginia Tech is a socio-cultural and secular organization that represents the interests and promotes the culture, heritage and way of life of the Indian society. The ISA serves as an ambassador of Indian traditions and values within the international community here at Tech by organizing various multi-cultural events and traditional festivals. We, thereby act as a channel through which students at VT may celebrate the true spirit of Vasudhaiva Kutumbakam.</p>
                </div>
                <div class="right">
                    <h2>SHH</h2>
                    <h4>Students Helping Honduras</h4>
                    <p>Students Helping Honduras (SHH) is a 501(c)(3) non-profit student organization whose mission is to mobilize students in a focused effort to empower orphaned and at-risk children in Honduras to reach their full potential.  This past winter 35 Hokies ventured down to Honduras to begin working on Eben Ezer, an elementary school that will provide a safe learning environment for roughly 160 children. In just a week those hard working Hokies worked alongside local Hondurans to start and finish the foundation.  However, a lot of work is still needed to be done.  It is our goal this semester to raise $25,000 in order to provide the materials to finish the school and have it open by June. </p>
                </div>
                <div class="clear"></div>
            </div>
            <div class="centered">
                <div class="content-box" style="display: inline-block">
                    <h2 style="margin-bottom: 0">Learn more about <a href="http://en.wikipedia.org/wiki/Holi"><span class="blue">Holi</span></a></h2>
                   <iframe width="560" height="315" src="http://www.youtube.com/embed/PO_hUM-pyos" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="content-box">
                <h3 id="clothing">Clothing</h3>
                <p>We highly recommend wearing white, whether it’s a white hoody, a white t-shirt, or a white dress shirt is up to you. Don’t plan on keeping it white though, the color usually washes out, but we cannot guarantee it won’t stain. </p>
                <h3 id="parking">Parking</h3>
                <p>Parking is available for free on campus, the closest parking lot is in front of Smyth Hall, as well as the Duck Pond parking lot, the McComas parking lot is also available at the south end of West Campus Drive.</p>
                <h3 id="risks">Risks</h3>
                <p>Although this is an extremely fun time, there are risks to participating. These include slips, falls, contact with other participants, and inappropriate behavior of other participants. The color is non-toxic but is made of turmeric which can hurt your eyes on contact, so be careful!</p>
                <p>To prevent these risks we highly recommend bring sunglasses, and avoid wearing contacts if possible, be careful and be kind!</p>
                <h3 id="photos">Photos</h3>
                <p>We will have several excellent photographers taking photos of the entire event, as well as a photo booth where you can get a picture of you and your friends directly! These photos will become available on our <a href="http://Facebook.com/TheColorWar">Facebook Page</a> after the event back. So check back to find YOUR awesome photo! </p>
            </div>

<?

printFooter();

?>