import app from 'flarum/admin/app';

app.initializers.add('flarum-essence', () => {
  app.extensionData.for('flarum-essence').registerPermission(
    {
      icon: 'fas fa-star',
      label: app.translator.trans('flarum-sticky.admin.permissions.essential_discussions_label'),
      permission: 'discussion.setEssential',
    },
    'moderate',
    95
  );
});
