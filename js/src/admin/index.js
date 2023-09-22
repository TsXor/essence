import app from 'flarum/admin/app';

app.initializers.add('essence', () => {
  app.extensionData.for('tsxor-essence').registerPermission(
    {
      icon: 'fas fa-star',
      label: app.translator.trans('flarum-essence.admin.permissions.essential_discussions_label'),
      permission: 'discussion.setEssential',
    },
    'moderate'
  );
});
