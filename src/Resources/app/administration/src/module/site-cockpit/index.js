import './page/site-cockpit-view';

Shopware.Module.register('site-cockpit', {
    type: 'plugin',
    name: 'S360SiteCockpitEasyVision',
    title: 'siteCockpit.general.title',
    description: 'siteCockpit.general.description',
    color: '#1798d8',
    routes: {
        settings: {
            component: 'site-cockpit-view',
            path: 'settings',
        },
    },
    settingsItem: [
        {
            group: 'plugins',
            to: 'site.cockpit.settings',
            icon: 'regular-universal-access',
            label: 'siteCockpit.general.title',
        },
    ],
    extensionEntryRoute: {
        extensionName: 'S360SiteCockpitEasyVision',
        route: 'site.cockpit.settings',
    },
});
