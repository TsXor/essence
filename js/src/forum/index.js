import app from 'flarum/forum/app';

import addEssentialBadge from './addEssentialBadge';
import addEssentialStateControl from './addEssentialControl';
import addEssentialExcerpt from './addEssentialExcerpt';
import addEssentialClass from './addEssentialClass';
import addEssentialDate from './addEssentialDate';

export { default as extend } from './extend';

app.initializers.add('flarum-essence', () => {
  addEssentialBadge();
  addEssentialStateControl();
  addEssentialExcerpt();
  addEssentialClass();
  addEssentialDate();
});
