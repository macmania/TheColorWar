<?
config()->title = 'FAQ';
config()->push('js', '/js/faq.js');
config()->push('css', '/css/faq.css');

printHeader();

?>
<div class="content-box">
  <h2>Frequently Asked Questions</h2>
  <?
  config()->each('faq', function($key, $qa) {
    ?>
    <div class="pair">
        <div class="question"><?=$qa['question']?></div>
        <div class="answer"><?=$qa['answer']?></div>
    </div>
    <?
  })
  ?>
</div>
<?

printFooter();

?>