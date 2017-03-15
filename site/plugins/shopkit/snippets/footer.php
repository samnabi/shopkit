</div><!-- .wrapper -->

<?= js('assets/plugins/shopkit/js/expand-collapse.min.js'); ?>

<?= js('assets/plugins/shopkit/js/fontfaceobserver.standalone.js'); ?>
<script>
  // Load font progressively (https://www.filamentgroup.com/lab/font-events.html)
  new FontFaceObserver('asap').load().then(function() {
    document.documentElement.className += " fonts-loaded";
  });
</script>

</body>
</html>