
function select_or_other_check_and_show(ele, page_init) {
  var speed;
  if (page_init) {
    speed = 0;
  } else {
    speed = 400;
    ele = $(ele).parents(".select-or-other")[0];
  }
  if ($(ele).find(".select-or-other-select option:selected[value=select_or_other], .select-or-other-select:checked[value=select_or_other]").length) {
    $(ele).find(".select-or-other-other").parent("div.form-item").show(speed);
  }
  else {
    $(ele).find(".select-or-other-other").parent("div.form-item").hide(speed);
    if (page_init)
    {
      // Special case, when the page is loaded, also apply 'display: none' in case it is
      // nested inside an element also hidden by jquery - such as a collapsed fieldset.
      $(ele).find(".select-or-other-other").parent("div.form-item").css("display", "none");
    }
  }
}

/**
 * The Drupal behaviors for the Select (or other) field.
 */
Drupal.behaviors.select_or_other = function(context) {
  $(".select-or-other:not('.select-or-other-processed')", context)
    .addClass('select-or-other-processed').each(function () {
    select_or_other_check_and_show(this, true);
  });
  // Use the click function for radios and checkboxes.
  $(".select-or-other-select", context).not("select").click(function () {
    select_or_other_check_and_show(this, false);
  });
  // Use the change function for selects.
  $("select.select-or-other-select", context).change(function () {
    select_or_other_check_and_show(this, false);
  });
};