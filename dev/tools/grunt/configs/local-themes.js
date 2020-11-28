/**
 * grunt exec:OleksiiBezpoiasnyi_luma_en_US && grunt less:OleksiiBezpoiasnyi_luma_en_US && grunt watch
 * grunt exec:OleksiiBezpoiasnyi_luma_ru_RU && grunt less:OleksiiBezpoiasnyi_luma_ru_RU && grunt watch
 */

module.exports = {
    OleksiiBezpoiasnyi_luma_en_US: {
        area: 'frontend',
        name: 'OleksiiBezpoiasnyi/luma',
        locale: 'en_US',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    },
    OleksiiBezpoiasnyi_luma_ru_RU: {
        area: 'frontend',
        name: 'OleksiiBezpoiasnyi/luma',
        locale: 'ru_RU',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    },
};
