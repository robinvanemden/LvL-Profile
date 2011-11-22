$Id: README.txt,v 1.13 2010/08/30 05:21:19 mattyoung Exp $

Extend form elements checkboxes & radios to display in multi-column

CCK support:
-----------
CCK field Multicolumn support is built-in for the following:

  Any text/integer/decimal/float field that uses the checkboxes, radios or select_or_other widget
  content taxonomy
  nodereference
  userreference

the CCK field configuration screen will have the multicolumn settings.

More CCK widget type can be added in your site's settings.php by adding this like:

  $conf['multicolumncheckboxesradios_extra_widget_types'] = array('some_cck_widget_type', 'some_more_cck_widget_type', 'etc');

Attention: 'some_cck_widget_type' is not the form element type id, it's the key
returned by the HOOK_widget_info() hook. You have to look into the CCK widget module
to find this key.

Webforms Usage:
--------------
See http://drupal.org/project/multicolumncheckboxesradios
or http://drupal.org/node/603900#comment-2228686


Code Usage:
----------
A new property '#multicolumn' can be specified to make checkboxes and radios
display in columns. This property takes an array with the following keys/values:

  'width' => number           (required): the number of column desired
  'row-major' => TRUE         (optional): go across the screen first, then down
  'indent' => number          (optional): number of space to indent the first row in columns
                                          for row-major or number of rows for the first column
                                          in column-major
  'caption' => string         (optional): table caption
  'column-heading' => array   (optional): specify the column heading as array of string
  'row-heading' => array      (optional): specify the row heading as array of string

In the definition of form element checkboxes/radios, add the '#multicolumn' property:
 
  $form['multicolumn_checkboxes'] = array(
   '#type' => 'checkboxes',
   '#multicolumn' => array('width' => 3,
                           'caption' => 'December',
                           'column-heading' => array(
                             t('heading 1'),
                             t('heading 2'),
                           )),
     .
     .
     .
  );

or

  $form['multicolumn_checkboxes'] = array(
   '#type' => 'checkboxes',
   '#multicolumn' => array('width' => 5, 'row-major' => TRUE),
     .
     .
     .
  );

  
Example:
  
4 checkboxes, set '#multicolumn' => array('width' => 3), it will be
shown in 3 columns:
 
       A    C   D
       B
 
set '#multicolumn' => array('width' => 3, 'row-major' => TRUE), it will be

       A    B    C
       D

WARNING: the column display is done by re-arranging the checkboxes/radios displayed into a HTML table.
The $form_state['values'][] array will not be in the same order as the '#options' array. If you want
to fetch checkbox state in the original '#options' order, iterate the $form_state['values'][]
array using the keys from '#options' array.
 
The markup is like this:

<table class="multicolumncheckboxesradios-table">
<thead><tr>                                                       <!-- only exist if column headings are present -->
 <th class="multicolumncheckboxesradios-heading-corner>...</th>   <!-- this only exist if both column and row headings are present -->
 <th class="multicolumncheckboxesradios-column-heading-first>...</th>
 <th class="multicolumncheckboxesradios-column-heading>...</th>
 ...
 <th class="multicolumncheckboxesradios-column-heading multicolumncheckboxesradios-column-heading-last>...</th>
</tr></thead> 
<tbody>
 <tr class="odd">
   <td class="multicolumncheckboxesradios-row-heading">...</td>    <!-- only exist if row headings are present -->
   <td class="multicolumncheckboxesradios-column-first multicolumncheckboxesradios-column">...</td>
   <td class="multicolumncheckboxesradios-column">...</td>
   ...
   <td class="multicolumncheckboxesradios-column multicolumncheckboxesradios-column-last">...</td>
 </tr>
 <tr class="even">
   <td class="multicolumncheckboxesradios-row-heading">...</td>
   <td class="multicolumncheckboxesradios-column-first multicolumncheckboxesradios-column">...</td>
   <td class="multicolumncheckboxesradios-column">...</td>
   ...
   <td class="multicolumncheckboxesradios-column multicolumncheckboxesradios-column-last">...</td>
 </tr>
 ...
 </tbody>
 </table>
