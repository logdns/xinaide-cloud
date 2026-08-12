# xinaide-cloud

一款为 [xinai.de](https://www.xinai.de/) 设计的清新 WordPress 博客主题。PHP 负责原生页面、SEO 与内容输出，Vue 3 + [Soybean UI](https://ui.soybeanjs.cn/) 负责搜索、移动菜单与深浅色切换。

![xinaide-cloud 主题预览](docs/desktop-preview.png)

## 特性

- 清新的薄荷绿与浅天蓝数字花园风格
- WordPress 原生首页、文章、页面、归档、搜索、404 与评论模板
- Vue 3 + Soybean UI 搜索、移动导航和深浅色切换
- 桌面、平板与手机响应式布局
- 支持 WordPress 菜单、小工具、自定义 Logo 和首页文案
- 原生 PHP 内容输出，兼顾 SEO 与插件兼容性

## 安装

1. 下载可安装包 [`xinaide-cloud.zip`](releases/xinaide-cloud.zip)，或下载仓库源码 ZIP。
2. 将主题压缩包上传到 WordPress「外观 → 主题 → 安装主题」。
3. 启用后到「外观 → 菜单」设置主导航和页脚导航。
4. 到「外观 → 小工具」设置博客侧栏。
5. 到「外观 → 自定义 → Xinaide Cloud 首页」修改首页文案。

压缩包已包含构建后的前端资源，服务器不需要 Node.js。

## 开发

```bash
npm install
npm run dev
npm run build
```

环境要求：WordPress 6.2+、PHP 7.4+、Node.js 16+（仅二次开发需要）。

## 许可证

[GPL-2.0-or-later](LICENSE)
