<?
printBarebonesHeader(false);

$name = isset($_GET['name']) ? $_GET['name'] : '';
$date = date("n/j/o");


?>
<style type="text/css">
  h2 {
    color: #000;
  }
  ol {
    margin: 0;
    padding-left:20px;
  }
  li {
    margin: 0;
    padding: 0;
  }
  body.nobackground {
    color: #999;
    background: #fff;
    position: relative;
    color: #000;
    font-size: 11pt;
    line-height: 20pt; 
    font-family: arial; 
  }
  #main {
    width: 800px;
    margin: 0 auto;
  }
</style>
<script type="text/javascript">
  mixpanel.track('waiver_viewed');
  window.print();
</script>
<div id="main">
  <h2>The Color War Liability Waiver</h2>

  <p>I, <span class="input-line" style="padding:0 80px;"><?=$name?></span>, intend to participate in the Color War organized by Students Helping Honduras, The Indian Student Association, and The Society of Indian Americans at Virginia Tech. The Color War is an event that will take place on April 28th, 2013, will be located outdoors at the corner of Grove Ln and West Campus Drive in Blacksburg, VA, and will include throwing of color powder at and around participants at The Color War, music, and other social activities. I understand that participation in the Color War is completely voluntary, and I can choose not to participate in it. I also acknowledge and understand that participation in the Color War is an inherently dangerous activity that puts me at a greater risk of injury, paralysis, and even death than if I don’t participate. </p>
  <p>I acknowledge that there are inherent risks in participating in the Color War.  Such inherent risks include, but are not limited to, the possibility that I could be injured by being inadvertently hit, pushed, or otherwise injured in some way by another participant in The Color War; by slipping, tripping, or otherwise falling on the ground; by losing my footing through my own misstep; by becoming dehydrated, overheated, chilled, or wet; by spraining a muscle or an ankle; by having a traffic accident on the way to or from the location of The Color War; by having an allergic reaction or similar to the color powder; by having the color powder come into contact with my eyes, mouth, throat, ears, skin, etc.; by having too high or too low blood pressure; by having a medical condition being aggravated by some factor during the event;  by becoming sick due to exposure to chemicals or bacteria located in the color powder; by not wearing proper clothing and/or footwear for the event; and so on.  The Color War  is  an activity conducted outdoors, and there are risks inherent in such outdoor activities such as injury from bad weather (e.g. rain, snow, sleet, extreme cold or heat, lightning, and high winds) and injury from wild animals (e.g. bears, snakes, stinging insects, etc.).  I hereby HOLD HARMLESS the Organizations, its officers, and its members and agree to INDEMNIFY them for any loss they sustain (including a reasonable attorney fee) from defending any lawsuit brought against them for injuries or property damage that arise from such inherent risks no matter who the plaintiff may be.</p>
  <p>I also acknowledge that the Organization could cause me injury through its own negligence or the negligence of one or more officers, members, or agents.  Such negligence includes, but is not limited to, failure to adequately select, inspect, or use the site for The Color War event; failure to adequately inform participants in The Color War of known dangers on the site of the event; failure to inform participants in The Color War about  rules and regulations for participation in the event; failure to provide or secure personnel  that have the ability to call emergency services and who can also provide first aid; failure to provide adequate information about the location of such personnel on the site of the event; failure to adequately address emergency situation and/or call 911; failure to warn participants of known dangers associated with the event; failure to visually ascertain participants’ condition at admission to the site of the event; and so on. I hereby ASSUME THE RISK of such negligence.  I also hereby agree to HOLD HARMLESS the Organizations, its officers, and its members and agree to INDEMNIFY them for any loss they sustain (including a reasonable attorney fee) from defending any lawsuit brought against them for injuries or property damage I sustain no matter who the plaintiff may be.</p>
  <p>I understand that this agreement does not prevent a lawsuit (by me or against me) based on injures or property damage caused by reckless or intentional acts. </p>
  <p>If any provision of this agreement is determined to be void or invalid, such determination shall not in an way affect any other provisions of this document, which shall continue to remain in full force and effect.</p>
  <p>I specifically intend for this document to survive my death and bind my next of kin and my estate.</p>
  <p style="margin-bottom: 20px;"><strong>I HAVE READ THIS DOCUMENT AND UNDERSTAND IT.</strong></p>

  <div class="user-signature">
    <div style="float:left; width:50%;">
      <div class="input-line"></div>
      <div>Signature</div>
    </div>

    <div style="float:right; width:40%">
      <div class="input-line"><?=$date?></div>
      <div>Date</div>
    </div>
    <div class="clear"></div>
  </div>

  <div class="emergency-info">
    <div style="float:left; width:50%;">
      <div class="input-line"></div>
      <div>Emergency Contact Name</div>
    </div>

    <div style="float:right; width:40%">
      <div class="input-line"></div>
      <div>Emergency Contact Phone #</div>
    </div>
    <div class="clear"></div>
  </div>

  <div class="medical-conditions" style="margin-top: 60px;">
    <strong>Pertinent Medical Conditions (allergic to bees, epi-pen, diabetic, high blood pressure, cardiovascular disease, etc.): </strong>
    <div class="input-line"></div>
    <div class="input-line"></div>
  </div>

  <hr style="border-bottom: solid 4px #000; margin: 20px 0"/>

  <p><strong>Only complete below if you are a parent or guardian of a participant under the age of 18:</strong></p>
  <p>I, the parent or guardian of the above named participant, have read through this waiver and all its terms, and I hereby give my approval to this child's participation in The Color War. I assume all risks and hazards incidental to my child's participation in The Color War, and I hereby waive, release, absolve, indemnify and agree to hold harmless the organizers of The Color War, for any injury to my child and from any and all claims, causes of actions, obligations, lawsuits, charges, complaints, controversies, covenants, agreements, promises, damages, costs, expenses, responsibilities, of whatsoever kind, nature or description, whether, direct or indirect, in law or in equity, in contract or in tort, or otherwise, whether known or unknown, from all claims or liabilities of any kind arising out of or connected with my child's participation in The Color War. I consent to the foregoing and grant permission for him/her to participate in The Color War. I acknowledge I have carefully read, accepted and agreed to the terms on this Assumption and Release and Liability waiver, and know and understand their contents and I sign the same on my own free act and deed.</p>

  <div class="guardian-info">
    <div style="float:left; width:50%;">
      <div class="input-line"><?=$name?></div>
      <div>Child Name</div>
    </div>

    <div style="float:right; width:40%">
      <div class="input-line"></div>
      <div>Age on Date of Event</div>
    </div>
    <div class="clear"></div>

    <div style="float:left; width:35%; margin-right: 5%">
      <div class="input-line"></div>
      <div>Parent/Guardian Name</div>
    </div>

    <div style="float:left; width:35%; margin-right: 5%">
      <div class="input-line"></div>
      <div>Parent/Guardian Signature</div>
    </div>

    <div style="float:left; width:20%">
      <div class="input-line"><?=$date?></div>
      <div>Date</div>
    </div>

    <div class="clear"></div>

  </div>
</div>
<?
printBarebonesFooter();
?>