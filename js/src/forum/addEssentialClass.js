import { extend } from 'flarum/common/extend';
import classList from 'flarum/common/utils/classList';

import DiscussionListItem from 'flarum/forum/components/DiscussionListItem';

export default function addEssentialClass() {
  extend(DiscussionListItem.prototype, 'elementAttrs', function (attrs) {
    if (this.attrs.discussion.isEssential()) {
      // "DiscussionListItem--xxx" will be appended to the class of discussion
      // elements, and you can use this class to give some special styles
      // to essential posts
      attrs.className = classList(attrs.className, 'DiscussionListItem--essential');
    }
  });
}
