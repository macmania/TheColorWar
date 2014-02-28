<?


config()->promos = array(
  'reddit' => array(
    'message' => 'Thanks for all your support VT reddit! Enjoy these special prices and make sure to share with your friends!',
    'discountPercent' => 15,
  ),
  'sia' => array(
    'message' => 'Thanks for all your support SIA members! Enjoy these special prices and make sure to share with your friends.',
    'discountPercent' => 20,
  ),
  'shh' => array(
    'message' => 'Thanks for all your support SHH members! Enjoy these special prices and make sure to share with your friends.',
    'discountPercent' => 20,
  ),
  'isa' => array(
    'message' => 'Thanks for all your support ISA members! Enjoy these special prices and make sure to share with your friends.',
    'discountPercent' => 20,
  ),
  'slacker' => array(
    'message' => false,
    'soakExtraPackets' => 1,
    'splashExtraPackets' => 1
  ),
  'superfan' => array(
    'message' => 'You rule! Thanks for signing up today for The Color War! Here\'s 23% off your total purchase.',
    'discountPercent' => 23,
  ),
  'pushpit' => array(
    'message' => 'BRUAAAHHHHHH!!!!',
    'discountPercent' => 30,
    'soakExtraPackets' => 1,
    'splashExtraPackets' => 1,
  ),
  'default' => array(
    'message' => false,
    'soakExtraPackets' => 0,
    'splashExtraPackets' => 0,
    'sprinkleExtraPackets' => 0,
    'soakDiscount' => 0,
    'shirtDiscount' => 0,
    'splashDiscount' => 0,
    'discountPercent' => 0,
    'discountAbsolute' => 0,
  )
);

?>