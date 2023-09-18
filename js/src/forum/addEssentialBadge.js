import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import Discussion from 'flarum/common/models/Discussion';
import Badge from 'flarum/common/components/Badge';

export default function addEssentialBadge() {
  extend(Discussion.prototype, 'badges', function (badges) {
    if (this.isEssential()) {
      badges.add(
        'essential',
        <Badge
          type="essential"
          label={app.translator.trans('flarum-essence.forum.badge.essential_tooltip')}
          icon="fas fa-star"
        />,
        10
      );
    }
  });
}
