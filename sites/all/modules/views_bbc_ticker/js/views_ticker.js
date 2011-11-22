$(document).ready(function() {
  if ($("#news-ticker").length > 0) {
    var startDelay = Drupal.settings.views_ticker.startDelay;
    var placeHolder = Drupal.settings.views_ticker.placeHolder;
    var options = {
      newsList : "#news-ticker",
      startDelay : startDelay,
      placeHolder1 : placeHolder
    }
    $().newsTicker(options);
  }
});