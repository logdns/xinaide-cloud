import { createApp, defineComponent, h, ref, onMounted } from 'vue';
import { SButton, SInput, SConfigProvider } from '@soybeanjs/ui';
import '@soybeanjs/ui/styles.css';
import './theme.css';

const config = window.xinaideCloud || {};

const Toolbar = defineComponent({
  name: 'XinaideCloudToolbar',
  setup() {
  const searchOpen = ref(false);
  const menuOpen = ref(false);
  const query = ref('');
  const dark = ref(false);

  onMounted(() => {
    dark.value = localStorage.getItem('xinaide-theme') === 'dark' || (!localStorage.getItem('xinaide-theme') && matchMedia('(prefers-color-scheme: dark)').matches);
    document.documentElement.dataset.theme = dark.value ? 'dark' : 'light';
  });

  const toggleTheme = () => {
    dark.value = !dark.value;
    document.documentElement.dataset.theme = dark.value ? 'dark' : 'light';
    localStorage.setItem('xinaide-theme', dark.value ? 'dark' : 'light');
  };

  const submitSearch = () => {
    const value = query.value.trim();
    if (value) window.location.href = `${config.searchUrl || '/'}?s=${encodeURIComponent(value)}`;
  };

  const navHtml = document.querySelector('#mobile-navigation')?.innerHTML || '';

    return () => h(SConfigProvider, { theme: { theme: { base: 'slate', primary: 'sky', feedback: 'classic', radius: '0.75rem' }, size: 'md' } }, {
    default: () => h('div', { class: 'toolbar-vue' }, [
      searchOpen.value && h('div', { class: 'search-popover' }, [
        h(SInput, { modelValue: query.value, 'onUpdate:modelValue': value => query.value = value, placeholder: config.labels?.placeholder || '输入关键词…', autofocus: true, onKeyup: event => event.key === 'Enter' && submitSearch() }),
        h(SButton, { color: 'primary', onClick: submitSearch }, () => config.labels?.search || '搜索文章')
      ]),
      h(SButton, { variant: 'ghost', class: 'icon-button', 'aria-label': config.labels?.search || '搜索', onClick: () => searchOpen.value = !searchOpen.value }, () => '⌕'),
      h(SButton, { variant: 'ghost', class: 'icon-button', 'aria-label': dark.value ? config.labels?.light : config.labels?.dark, onClick: toggleTheme }, () => dark.value ? '☀' : '◐'),
      h(SButton, { variant: 'ghost', class: 'icon-button mobile-menu-button', 'aria-label': config.labels?.menu || '菜单', onClick: () => menuOpen.value = true }, () => '☰'),
      menuOpen.value && h('div', { class: 'mobile-drawer-backdrop', onClick: () => menuOpen.value = false }, [
        h('aside', { class: 'mobile-drawer', onClick: event => event.stopPropagation() }, [
          h('div', { class: 'drawer-header' }, [h('strong', config.siteName || 'xinai.de'), h(SButton, { variant: 'ghost', onClick: () => menuOpen.value = false }, () => '×')]),
          h('nav', { class: 'mobile-drawer-nav', innerHTML: navHtml })
        ])
      ])
    ])
    });
  }
});

const mount = document.querySelector('#xinaide-cloud-toolbar');
if (mount) createApp(Toolbar).mount(mount);
