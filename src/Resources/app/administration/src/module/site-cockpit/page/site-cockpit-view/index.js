const {Criteria} = Shopware.Data;
const {Mixin} = Shopware

import template from './site-cockpit-view.html.twig';

Shopware.Component.register('site-cockpit-view', {
    template,
    inject: ['repositoryFactory', 'themeService'],
    mixins: [Mixin.getByName('notification')],

    data() {
        return {
            domainId: null,
            sitekey: '',
            sitekeyObject: null,
            sitekeyId: '',
            loading: false,
        };
    },
    computed: {
        salesChannelRepository() {
            return this.repositoryFactory.create('sales_channel')
        },
        domainRepository() {
            return this.repositoryFactory.create('sales_channel_domain');
        },
        siteKeyRepository() {
            return this.repositoryFactory.create('domain_sitekey');
        },

        // removes any domain containing headless

        domainFilter() {
            const criteria = new Criteria(1, 25);

            criteria.setLimit(1);

            criteria.addFilter(
                Criteria.not('AND', [Criteria.contains('url', 'headless')])
            );
            return criteria;
        },
    },

    methods: {
        changeDomain() {
            this.getSitekey();
        },
        getSitekey() {
            const criteria = new Criteria();

            this.loading = true;

            criteria.addFilter(Criteria.equals('domainID', this.domainId));

            this.siteKeyRepository
                .search(criteria, Shopware.Context.api)
                .then((entity) => {
                    if (entity[0] && entity[0].sitekey) {
                        this.sitekey = entity[0].sitekey;
                        this.sitekeyId = entity[0].id;
                        this.sitekeyObject = entity[0];
                    } else {
                        this.sitekey = '';
                        this.sitekeyId = '';
                        this.sitekeyObject = null;
                    }

                    this.loading = false;
                });
        },
        onSubmit() {
            if (this.sitekeyId) {
                this.updateSitekey().then(() => this.compileTheme());
            } else this.createSitekey().then(() => this.compileTheme());
        },

        async updateSitekey() {
            this.loading = true;

            this.sitekeyObject.sitekey = this.sitekey;

            this.sitekeyObject.domainID = this.domainId;

            this.siteKeyRepository
                .save(this.sitekeyObject, Shopware.Context.api)
        },

        async compileTheme() {
            const criteria = new Criteria()
            criteria.addAssociation('themes');
            criteria.addAssociation('domains')
            criteria.addFilter(
                Criteria.equals('domains.id', this.domainId
                ))

            let salesChannels = await this.salesChannelRepository.search(
                criteria,
                Shopware.Context.api
            )

            for (let salesChannel of salesChannels) {
                const theme = salesChannel.extensions.themes.first()

                if (theme) {
                    await this.themeService.assignTheme(theme.id, salesChannel.id)
                    this.createNotificationSuccess({
                        message: `${salesChannel.translated.name}: ${this.$t('siteCockpit.general.themeCompiled')}`,
                    })
                }
            }

            this.loading = false;

            this.createNotificationSuccess({
                message: this.$t('siteCockpit.general.settingsSaved'),
            })


        },

        async createSitekey() {
            this.loading = true;

            this.sitekeyObject = this.siteKeyRepository.create(
                Shopware.Context.api
            );

            this.sitekeyObject.sitekey = this.sitekey;

            this.sitekeyObject.domainID = this.domainId;

            this.siteKeyRepository
                .save(this.sitekeyObject, Shopware.Context.api)
                .then(() => {
                    this.getSitekey();
                });
        },
    },

    created() {
        this.domainRepository
            .search(this.domainFilter, Shopware.Context.api)
            .then((entity) => {
                this.domainId = entity[0].id;
                this.getSitekey();
            });
    },
});
