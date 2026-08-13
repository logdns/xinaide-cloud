import { createApp, defineComponent, h, ref, onMounted, onBeforeUnmount } from 'vue';
import { SButton, SInput, SConfigProvider, STooltip, SBacktop } from '@soybeanjs/ui';
import '@soybeanjs/ui/styles.css';
import './theme.css';

const config = window.xinaideCloud || {};

const SOYBEAN_THEME = { theme: { base: 'slate', primary: 'sky', feedback: 'classic', radius: '0.75rem' }, size: 'md' };

const SOCIAL_ICONS = {
  github: '<path d="M12 .5C5.65.5.5 5.65.5 12c0 5.08 3.29 9.39 7.86 10.91.58.11.79-.25.79-.55v-2.17c-3.2.7-3.87-1.36-3.87-1.36-.52-1.33-1.28-1.68-1.28-1.68-1.05-.71.08-.7.08-.7 1.16.08 1.77 1.19 1.77 1.19 1.03 1.76 2.7 1.25 3.36.96.1-.75.4-1.26.72-1.55-2.55-.29-5.23-1.28-5.23-5.68 0-1.26.45-2.28 1.19-3.09-.12-.29-.52-1.46.11-3.05 0 0 .97-.31 3.18 1.18a11.1 11.1 0 0 1 5.8 0c2.2-1.49 3.17-1.18 3.17-1.18.63 1.59.23 2.76.12 3.05.74.81 1.18 1.83 1.18 3.09 0 4.41-2.69 5.38-5.25 5.67.41.36.78 1.05.78 2.13v3.16c0 .3.2.67.8.55A11.51 11.51 0 0 0 23.5 12C23.5 5.65 18.35.5 12 .5Z"/>',
  telegram: '<path d="M23.9 3.6 20.3 20.6c-.27 1.2-.98 1.5-1.98.93l-5.48-4.04-2.64 2.55c-.3.3-.54.54-1.1.54l.39-5.53L19.6 5.9c.44-.39-.1-.61-.68-.22L6.46 13.9.99 12.2c-1.19-.37-1.21-1.19.25-1.76L22.5 2.35c.99-.36 1.86.22 1.4 1.25Z"/>',
  weibo: '<path d="M10.1 20.9c-3.9.4-7.2-1.3-7.5-3.9-.3-2.5 2.7-4.9 6.6-5.3 3.9-.4 7.2 1.3 7.5 3.9.3 2.5-2.7 4.9-6.6 5.3Zm4.4-3.1c-.2 1.6-2.3 2.9-4.7 2.9-2.4.1-4.4-1.1-4.2-2.7.2-1.6 2.3-2.9 4.7-2.9s4.4 1.1 4.2 2.7Zm-3.1.3c-.9-.1-1.9.3-2.1 1-.2.7.5 1.3 1.4 1.4.9.1 1.9-.3 2.1-1 .2-.7-.5-1.3-1.4-1.4Zm-.8.4c-.3 0-.5.2-.6.4 0 .2.2.4.5.4.3 0 .5-.2.6-.4 0-.2-.2-.4-.5-.4Zm7.2-3.2c-.4.1-.8-.2-.9-.6-.3-1.1-1.4-1.8-2.5-1.5-.4.1-.8-.2-.9-.6-.1-.4.2-.8.6-.9 2-.5 3.9.8 4.4 2.8.1.4-.2.8-.7.8Zm2.3-1c-.4.1-.8-.2-.9-.6-.6-2.3-2.9-3.7-5.2-3.1-.4.1-.8-.2-.9-.6-.1-.4.2-.8.6-.9 3.1-.8 6.2 1.1 7 4.2.1.4-.2.8-.6 1Zm-6.2 5.3c-2.3 2.4-5.9 3.1-8.1 1.5-2.1-1.5-2.3-4.5-.5-6.9-.4.1-.8.3-1.2.5-2.3 1.3-3.2 3.7-2.1 5.5 1.2 1.9 4.1 2.2 6.6.9 1.6-.8 2.9-2.1 3.6-3.6.6-.3 1.2-.7 1.7-1.1.2.4.2.9 0 1.2Z"/>',
  bilibili: '<path d="M6.3 3.2c.3-.3.8-.3 1.1 0L9 4.8h6L16.6 3.2c.3-.3.8-.3 1.1 0 .3.3.3.8 0 1.1l-.8.8h1.3c1.9 0 3.4 1.5 3.4 3.4v8.9c0 1.9-1.5 3.4-3.4 3.4H5.8c-1.9 0-3.4-1.5-3.4-3.4V8.5c0-1.9 1.5-3.4 3.4-3.4h1.3l-.8-.8c-.3-.3-.3-.8 0-1.1ZM5.8 6.7c-1 0-1.8.8-1.8 1.8v8.9c0 1 .8 1.8 1.8 1.8h12.4c1 0 1.8-.8 1.8-1.8V8.5c0-1-.8-1.8-1.8-1.8H5.8Zm3 3.9c.5 0 .9.4.9.9v1.8c0 .5-.4.9-.9.9s-.9-.4-.9-.9v-1.8c0-.5.4-.9.9-.9Zm6.4 0c.5 0 .9.4.9.9v1.8c0 .5-.4.9-.9.9s-.9-.4-.9-.9v-1.8c0-.5.4-.9.9-.9Z"/>',
  x: '<path d="M18.9 1.2h3.7l-8.1 9.3L24 23.2h-7.5l-5.9-7.7-6.7 7.7H.2l8.7-9.9L0 1.2h7.7l5.3 7 5.9-7Zm-1.3 19.8h2L6.6 3.3h-2.2l13.2 17.7Z"/>',
  youtube: '<path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 0 0 .5 6.2 31.3 31.3 0 0 0 0 12a31.3 31.3 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 0 0 2.1-2.1A31.3 31.3 0 0 0 24 12a31.3 31.3 0 0 0-.5-5.8ZM9.5 15.6V8.4L15.8 12l-6.3 3.6Z"/>',
  email: '<path d="M2.4 4.5h19.2c.5 0 .9.4.9.9v13.2c0 .5-.4.9-.9.9H2.4c-.5 0-.9-.4-.9-.9V5.4c0-.5.4-.9.9-.9Zm9.6 7.7L3.3 6.3v11.9h17.4V6.3L12 12.2Zm-7.5-6h15L12 10.4 4.5 6.2Z"/>',
  wechat: '<path d="M9.3 3.5C5.2 3.5 1.9 6.3 1.9 9.7c0 1.9 1 3.6 2.7 4.8l-.7 2.1 2.4-1.2c.6.2 1.2.3 1.9.4-.1-.4-.2-.9-.2-1.4 0-3.3 3.2-6 7.1-6 .3 0 .6 0 .9.1-.6-2.8-3.5-5-6.7-5Zm-2.7 3.6c.5 0 .9.4.9.9s-.4.9-.9.9-.9-.4-.9-.9.4-.9.9-.9Zm5.4 0c.5 0 .9.4.9.9s-.4.9-.9.9-.9-.4-.9-.9.4-.9.9-.9Zm10.1 7.3c0-2.8-2.8-5.1-6.2-5.1s-6.2 2.3-6.2 5.1 2.8 5.1 6.2 5.1c.7 0 1.4-.1 2-.3l2 1-.6-1.7c1.7-1 2.8-2.5 2.8-4.1Zm-8.3-.9c-.4 0-.8-.3-.8-.8s.4-.8.8-.8.8.3.8.8-.4.8-.8.8Zm4.1 0c-.4 0-.8-.3-.8-.8s.4-.8.8-.8.8.3.8.8-.3.8-.8.8Z"/>',
  qq: '<path d="M12 2.5c-3 0-5.4 2.3-5.4 5.5 0 .3 0 .6.1.9-.5.9-1.2 2.3-1.2 3.6 0 .4.4.6.7.3.3-.2.6-.7.9-1.1.3 1.5 1.2 2.9 2.4 3.7-.9.3-1.9.7-2.4 1-.6.3-.8.8-.4 1.2.6.6 2.1 1 3.3 1 .9 0 1.6-.3 2-.6.4.3 1.1.6 2 .6 1.2 0 2.7-.4 3.3-1 .4-.4.2-.9-.4-1.2-.5-.3-1.5-.7-2.4-1 1.2-.8 2.1-2.2 2.4-3.7.3.4.6.9.9 1.1.3.3.7.1.7-.3 0-1.3-.7-2.7-1.2-3.6.1-.3.1-.6.1-.9 0-3.2-2.4-5.5-5.4-5.5Z"/>',
  rss: '<path d="M4 4.4v3.1c6.9 0 12.5 5.6 12.5 12.5h3.1C19.6 11.3 12.7 4.4 4 4.4Zm0 6.2v3.1c3.5 0 6.3 2.8 6.3 6.3h3.1c0-5.2-4.2-9.4-9.4-9.4ZM6.2 16a2.2 2.2 0 1 0 0 4.4 2.2 2.2 0 0 0 0-4.4Z"/>'
};

const socialIconSvg = key => `<svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true" focusable="false">${SOCIAL_ICONS[key] || '<circle cx="12" cy="12" r="9"/>'}</svg>`;

const copyText = async text => {
  try {
    await navigator.clipboard.writeText(text);
    return true;
  } catch (error) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.cssText = 'position:fixed;opacity:0';
    document.body.appendChild(textarea);
    textarea.select();
    let ok = false;
    try { ok = document.execCommand('copy'); } catch (e) { ok = false; }
    textarea.remove();
    return ok;
  }
};

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

    return () => h(SConfigProvider, { theme: SOYBEAN_THEME }, {
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

const FooterApp = defineComponent({
  name: 'XinaideCloudFooter',
  setup() {
    const socials = Array.isArray(config.socials) ? config.socials : [];
    const copiedKey = ref('');
    let copiedTimer = null;

    const handleCopy = async social => {
      const ok = await copyText(social.value || '');
      if (!ok) return;
      copiedKey.value = social.key;
      clearTimeout(copiedTimer);
      copiedTimer = setTimeout(() => { copiedKey.value = ''; }, 2000);
    };

    onBeforeUnmount(() => clearTimeout(copiedTimer));

    const renderSocial = social => {
      const content = copiedKey.value === social.key ? '已复制 ✓' : (social.tip || social.label);
      const trigger = social.type === 'copy'
        ? h('button', { type: 'button', class: ['footer-social', copiedKey.value === social.key && 'is-copied'], 'aria-label': social.label, innerHTML: socialIconSvg(social.key), onClick: () => handleCopy(social) })
        : h('a', { class: 'footer-social', href: social.href, target: '_blank', rel: 'noopener nofollow', 'aria-label': social.label, innerHTML: socialIconSvg(social.key) });
      return h(STooltip, { key: social.key, content, placement: 'top', showArrow: true }, { trigger: () => trigger });
    };

    return () => h(SConfigProvider, { theme: SOYBEAN_THEME }, {
      default: () => h('div', { class: 'footer-socials-vue' }, [
        ...socials.map(renderSocial),
        h(SBacktop, { class: 'footer-backtop', visibilityHeight: 480, variant: 'soft', color: 'primary', shape: 'circle', 'aria-label': '回到顶部' }, () => '↑')
      ])
    });
  }
});

const footerMount = document.querySelector('#xinaide-cloud-footer-app');
if (footerMount) createApp(FooterApp).mount(footerMount);

const header = document.querySelector('.site-header');
const updateHeader = () => header?.classList.toggle('is-scrolled', window.scrollY > 24);
updateHeader();
window.addEventListener('scroll', updateHeader, { passive: true });

const toc = document.querySelector('[data-xinaide-toc]');
if (toc) {
  const headings = [...document.querySelectorAll('.entry-content h2, .entry-content h3')];
  if (headings.length > 1) {
    const list = toc.querySelector('ol');
    headings.forEach((heading, index) => {
      if (!heading.id) heading.id = `section-${index + 1}`;
      const item = document.createElement('li');
      if (heading.tagName === 'H3') item.className = 'toc-depth-3';
      const link = document.createElement('a');
      link.href = `#${heading.id}`;
      link.textContent = heading.textContent || '';
      item.appendChild(link);
      list.appendChild(item);
    });
    toc.hidden = false;
  }
}

document.querySelectorAll('[data-xinaide-like]').forEach(button => {
  button.addEventListener('click', async () => {
    if (button.disabled) return;
    button.disabled = true;
    const data = new FormData();
    data.append('action', 'xinaide_cloud_like');
    data.append('nonce', config.likeNonce || '');
    data.append('post_id', button.dataset.postId || '');
    try {
      const response = await fetch(config.ajaxUrl || '/wp-admin/admin-ajax.php', { method: 'POST', body: data, credentials: 'same-origin' });
      const result = await response.json();
      const count = result?.data?.count;
      if (typeof count !== 'undefined') button.querySelector('[data-like-count]').textContent = count;
      button.classList.add(result.success ? 'is-liked' : 'is-duplicate');
      const label = button.querySelector('em');
      if (label) label.textContent = result.success ? '谢谢喜欢' : (result?.data?.message || '已经点过赞');
    } catch (error) {
      button.disabled = false;
    }
  });
});
