import './page/site-cockpit-view';

Shopware.Module.register('site-cockpit', {
    type: 'plugin',
    name: 'SiteCockpit',
    title: 'SiteCockpit',
    description: 'SiteCockpit Settings',
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
            label: 'Site-Cockpit',
        },
    ],
    extensionEntryRoute: {
        extensionName: 'SiteCockpit',
        route: 'site.cockpit.settings',
    },
});
