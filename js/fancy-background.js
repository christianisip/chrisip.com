/*
 * fancy-background v1.0.0
 *
 * Copyright (c) 2016 flinbu
 * Dual licensed under the MIT and GPL licenses.
 *
 */

function fancyBackground(el, lines, lineWidth, minHeightPCT, maxHeightPCT, spaceGutter, animDuration, colors) {

  var winWidth = el.width(),
      spaceLines = lines * lineWidth,
      fancyHolder = $('<div>')
        .attr('class', 'fancy-holder').css({
          width : '100%',
          height : '100%',
          position : 'fixed',
          overflow : 'hidden',
          left : 0,
          top : 0,
          zIndex : -1
        });
  if (animDuration < 20) {
    animDuration = 20;
  }
  function generate() {
    if (!lines) {
      var totalLW = lineWidth + (spaceGutter),
          lines = Math.floor(winWidth / totalLW);
    }
    el.find('.fancy-holder').find('div').remove();
    el.addClass('fancy-background')
      .append(fancyHolder);
    for (i = 0; i < lines; i++) {
      var randompct = Math.floor(Math.random() * (maxHeightPCT - minHeightPCT + 1) + minHeightPCT),
          top = (100 - randompct) / 2,
          line = $('<div>')
            .attr('class', 'fancy-line')
            .css({
              position : 'absolute',
              width : lineWidth + 'px',
              height : randompct + '%',
              left : spaceGutter + (lineWidth * i) + (spaceGutter * i) + 'px',
              top : -(fancyHolder.height() * (randompct/100)) + 'px',
              borderRadius : '0px'
            });
      if (colors) {
        var randColor = Math.floor(Math.random() * (colors.length - 1));
        line.css('background-color', colors[randColor]);
      }
      line.appendTo(fancyHolder);
    }
    var theLines = fancyHolder.find('.fancy-line'),
        randDuration = 0;
    theLines.each(function() {
      var oTop = $(this).css('top'),
          randTime = Math.floor(Math.random() * (lines)),
          item = $(this),
          interval = (animDuration * 1000),
          turn = Math.floor(Math.random() * (5) + 1),
          randTop = Math.floor(Math.random() * (fancyHolder.height() - item.height()));
      if (turn == 2) {
        item.css('top', randTop + 'px');
          animate_item(item);
      }
      setTimeout(function() {
        animate_item(item);
        setInterval(function() { animate_item(item) }, interval);
      }, randDuration * 1000);
      randDuration = Math.floor(Math.random() * animDuration);
    });
  }
  function animate_item(item) {
    item.animate({
      top : fancyHolder.height()
    }, animDuration * 1000, 'linear', function() {
      item.css('top', -item.height() + 'px');
    });
  }
  generate();
  $(window).on('resize', function() {
    generate();
  });
}
(function ($) {
  $.fn.fancyBackground = function(options) {
    var el = $(this),
        settings = $.extend({
          lines : true,
          lineWidth : 10,
          minHeightPCT : 40,
          maxHeightPCT : 80,
          spaceGutter : false,
          duration : 30
        }, options);
    fancyBackground(el, settings.lines, settings.lineWidth, settings.minHeightPCT, settings.maxHeightPCT, settings.spaceGutter, settings.duration, settings.colors);
  };
})(jQuery);
