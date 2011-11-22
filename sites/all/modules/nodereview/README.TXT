
ABOUT

This module allows users to write reviews of any other node in the system.  Each
review is itself a node, which in turn can be reviewed as well.  The format of 
a review is fully configurable by the admin, and includes both a numeric and
textual grade in an arbitrary number of axes.

REQUIREMENTS

- Drupal 6
- Views module
- VotingAPI module

INSTALLATION

- Copy the nodereview directory to your modules directory.
- Go to admin/build/modules and enable it.
- Go to admin/user/access and set proper permissions.
- Reviews can be enabled for a specific node type on the node configuration page (admin/content/types) 
or on the review configuration page(admin/content/nodereview).
- Review axes can be configured per-node type on admin/content/nodereview/<typename>


FEATURES
Fivestar has been implemented as an optional feature to use
in place of the conventional rating system


AUTHORS AND CREDIT

Larry Garfield
larry at garfieldtech dot com
http://www.garfieldtech.com/

John Forsythe
john at blamcast dot net
http://blamcast.net/

This module was initially developed for EdibleSense.com, and released to the Drupal
community under the GNU General Public License v2.

Additional funding for this module has been provided by (in the order added):

- Dublit.com
