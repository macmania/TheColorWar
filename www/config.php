<?

include 'promos.php';

// Set up database access
DB::$user = "thecolorwar";
DB::$password = "PsychoColor1!";
DB::$dbName = "thecolorwar";
DB::$host = "thecolorwar.db.10654488.hostedresource.com";

config()->adminPassword = "colormesilly";

config()->pricePerPacket = .8;

config()->googleMerchantId = '711318365992931';
// Never share this with anybody!
config()->googleMerchantKey = 'lA4Gx3zTuc7nIM9LT3gEUg';

// Contact info
config()->email = "thecolorwar@gmail.com";
config()->phone = "(303) 229 - 1092";


//config()->registrationNotice = "<center>If you wanted <strong>colors</strong> or a <strong>shirt</strong>, but did not register in time,
//                                 we have extra for sale at the event, but show up <strong>early</strong> because we'll 
//                                 <strong>sell out fast!</strong></center>";
//config()->discountText = "";

// Prices
config()->soakPrice = 13;
config()->splashPrice = 7;
config()->shirtPrice = 13;

// Price for XX-Larges
config()->shirtExtraPrice = 2;

// Number of color packets per package
config()->soakPackets = 5;
config()->splashPackets = 2;
config()->sprinklePackets = 1;

// To remove the discounts just remove the two lines below this
//config()->soakDiscountedPrice = 6.99;
//config()->splashDiscountedPrice = 3.99;
// onfig()->shirtDiscountedPrice = 7.99;

config()->credits = "Web Design by Rishi Ishairzay, Ian Madsen and Emily Rathmanner";

config()->pages = array(
  "Home" => "home",
  "About" => "about",
  "Registration" => "registration",
  "FAQ" => "faq",
  "Contact" => "contact",
);

config()->faq = array(
 //array(
 //   'question' => 'When Is The Color War?',
 //   'answer'   => 'The Color War is April, 28th, 2013 at noon o\'clock sharp, which is 
 //                 when the first round of colors will be thrown. The gates will open at 
 //                 11:30am and everything happens at once so try to be a little early!'
 // ),
 // array(
 // 'question' => 'What If It Rains?',
//  'answer'   => 'We are all about fun, but we also want you guys to be safe! So if it rains, we\'re still
 //                 going to be there and we hope you will be too, but we want you to be careful! However if 
 //                 it there is nearby lightening or a torrential downpour we will have to call the event off 
 //                 in effort to keep you all safe! In the unlikely case that it does get cancelled, you will
 //                 still receive everything you purchased!'
 // ),
 //   array(
 //   'question' => 'Once I\'ve Ordered My Colors, Where Do I Get Them?',
 //   'answer'   => 'All your color will be available for pickup at the event, be sure to 
 //                 bring your email confirmation with you to claim your colors! Also be 
 //                 sure to bring your signed waiver!'
 // ),
     array(
    'question' => 'Where Will It Be Happening?',
    'answer'   => 'It will be happening on Virginia Tech\'s campus at The Duck Pond Field
                   on West Campus Drive. Refer to our <a href="/about">About</a> page more detailed info.'
  ),
      array(
    'question' => 'What Should I Wear And Bring?',
    'answer'   => 'We highly recommend wearing white and prepare to get it colored! The Colors are water
                   soluble, but that doesn\'t mean they won\'t temporarily stain, and we don\'t guarantee 
                   they won\'t permanently stain! So wear clothes that you don\'t really care about. When
                   you wash them afterwards, be sure to wash them separate from the rest of your clothes!
                   <p>
                   Colors, T-shirts and photos will be sold at the event both by cash and credit card.
                   If you think you will be interested in getting some extras we do recommend bringing a 
                   little extra money! Feel free to bring a SMALL bag, a "Free Hugs" poster or something else that
                   will get you and your friends excited! We do ask that you do not bring food, drinks, or 
                   pets to the event.'

  ),
    array(
    'question' => 'You Keep Saying "Color", What Is It?',
    'answer'   => 'Color is what we call it in the industry, but for all intents and purposes 
                  it is the colored powder you will throw everywhere! Gluten intolerant? No 
                  Problem, our ingredients are 100% Kosher. Worried about the taste? No problem,
                   made 100% from natural ingredients such as Turmeric. Worried about your skin? 
                   For one last time, no problem, the turmeric base is actually good for skin and 
                   makes you softer than a baby’s bottom when you\'re done. For entire list of 
                   ingredients <a target="_blank" href="http://e-coexist.com/products/holi/ingredients-of-natural-holi-colours">Click Here.</a>'
  ),
    array(
    'question' => 'What Are The Risks Associated With The Color War?',
    'answer'   => 'Slips, falls, contact with other participants, negligent or wanton acts of other 
                  participants, any defects or condition of premises, or color zones, the effects 
                  of the weather including, but not limited to, high heat, cold temperatures, storms
                  and/or humidity. All such risks being known, are assumed and appreciated by you. 
                  The color is non-toxic but is made of turmeric which can hurt your eyes if it gets
                  inside them, we highly recommend bring sunglasses, and avoid wearing contacts if possible'
  ),
 //   array(
 //   'question' => 'I Am Having Trouble Registering, What Do I Do?',
 //   'answer'   => 'One solution is Clearing your Cache and Deleting your Cookies.
 //                 (Please don\'t throw away your chocolate chip cookies though, we mean your internet cookies!)
 //                 If you used a Virginia Tech email address and it didn\'t work, try using a Gmail address.
 //                 If you still are having trouble please contact us.'
 // ),
 // array(
 //   'question' => 'How Much Does It Cost?',
 //   'answer'   => 'Refer to "How much color do I get" for more details on color. But the
 //                  event is free to attend, however you will be missing out on the best 
 //                  part, THROWING COLORS if you don\'t! If you would like to buy a T-shirt 
 //                  refer to "Where do I get my wicked awesome Color War Shirt??'
 // ),
  array(
    'question' => 'Do I Have To Buy Colors To Go?',
    'answer'   => 'No you do not have to buy colors, but REALLY?! That\'s the best part of 
                  going! All of the profit from the sales of colors goes to Students Helping 
                  Honduras to build a school. So you\'re having fun, while giving kids an education!'
  ),
  array(
    'question' => 'How Much Color Do I Get?',
    'answer'   => 'You have two options, you can get 2 packets for $5 or 5 packets for $10. But 
                  hurry this only last between March 6th and March 17th, 2013! So get the early bird 
                  deal while you can! After that online prices are 2 packets for $5.00 and 5 packets 
                  for $10.00. Online color purchases will end on April 15th, and then you have to wait 
                  until the day of and pay a markup!'
  ),
  array(
    'question' => 'How Do I Get The Color To Stay In My Shirt?',
    'answer'   => 'Get out the clear coat spray paint and apply 50 layers or until the shirt
                  is stiff. That\'s one way, or you can spray with vineger and iron it in, 
                  before you wash it! (Thank you Color Me Rad)'
  ),
//  array(
//    'question' => 'Where Do I Get My Wicked Awesome Color War Shirt?',
//    'answer'   => 'Shirts are sold online under Registration for $10.00 and can be picked
//                   up on the Drillfield the week before the event and at the event. They will also be sold
//                   at the event, but for $15.00, save some money and order online!'
//  ),
  array(
    'question' => 'What Is This "Waiver" Business?',
    'answer'   => 'To purchase Color and go to the event you must fill out a waiver, which means
                  you acknowledge the risks associated with Color!'
  ),
  array(
    'question' => 'I Want An Outanding Photo Of My Friends, But Don\'t Want To Bring My Camera!',
    'answer'   => 'We aren\'t fortune tellers, but we had a feeling! So we\'re here to help you 
                  out! We are bringing in several crackerjack photographers just for you! Check back 
                  on the website after the event to buy a photo!'
  ),
   array(
    'question' => 'Can I Take The Color Home?',
    'answer'   => 'If you paid for your color, yes you can take it home, but keep in mind you will be losing out 
                  on a lot of the fun at the event! If you do choose to take some home, please do not use it
                  to vandalize any public or private property that you do not own.'
  ),
    array(
    'question' => 'Who Wins In The Color War?',
    'answer'   => 'It depends on what you classify as winning! As far as we\'re concerrned, whoever is 
                  plastered with the most color wins, but anyone one who particpates is winning because the\'re
                  having the best time of their life!'
  ),
    array(
    'question' => 'What If I Forget To Register Online Before The Event?',
    'answer'   => 'Your attendance is important to us! We want you there as much as you want to be there and in 
                  order for you to have every opportunity to come, we will have registration open the entire day 
                  of the event! However keep in mind that the later you register the more color costs. Refer to 
                  "How Much Does It Cost" for more information on pricing.'
  ),
    array(
    'question' => 'Can I Bring My Pet?',
    'answer'   => 'We all love our animals, but unfortunately we ask that you leave your four legged companions at 
                   home because some people have severe alergies to some animals.'
  ),
    array(
    'question' => 'If I Leave During The Event Can I Come Back In?',
    'answer'   => 'Of course! But if you already received your free packet of color, you will not get receive a second. When
                  you return we\'re expecting you to come back with more people!'
  )
);


config()->push('js', '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
config()->push('js', '/js/main.js');
config()->push('js', '/js/clearbox.js');

config()->push('css', 'http://fonts.googleapis.com/css?family=Patrick+Hand+SC|Roboto:300,300italic,700,700italic');
config()->push('css', '/css/main.css');



?>