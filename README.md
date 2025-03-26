# Acorn Docs

📚 Automatically generate documentation for your ACF Composer blocks in [Sage](https://roots.io/sage) projects using [Acorn](https://roots.io/acorn/).

---

## ✨ Features

- Parses your `app/Blocks` or custom block paths
- Extracts metadata like `name`, `description`, `supports`, `styles`, etc.
- Supports custom PHPDoc annotations for additional metadata. Editable via config.
- Outputs Markdown docs via Blade views (fully customizable)
- Designed for Acf-composer users

---

## 🚀 Installation

```bash
composer require aon/acorn-docs --dev
```

---

## ⚙️ Configuration

Publish the config file to customize block paths or output location:

```bash
wp acorn vendor:publish --provider="Aon\AcornDocs\Providers\AcornDocsServiceProvider" --tag=config
```

This will create `config/acorn-docs.php` with default paths like:

```php
'paths' => [
    [
        'namespace' => 'App\\Blocks\\',
        'directory' => 'app/Blocks',
    ],
],
'output_path' => base_path('docs/blocks'),
```

---

## 🎨 Customizing Output

To customize the Markdown output view, publish the views:

```bash
wp acorn vendor:publish --tag=views
```

Then edit `resources/views/vendor/acorn-docs/markdown.blade.php` as needed.

You can use `$block->name`, `$block->description`, and other fields directly in Blade.

---

## 🛠 Usage

Generate documentation with:

```bash
wp acorn docs:generate
```

This will scan your configured block directories and output Markdown files to `docs/blocks/`.

---

## 🧱 Example Output

```markdown
# Hero Block

**Description:** A hero section with image and text  
**Category:** layout  
**Icon:** hero-icon

## Supports

```json
{
  "align": true,
  "anchor": true
}
```
```

---

## 🧪 Testing & Extending

You can extend the parser or renderer by binding your own implementations:

```php
$this->app->bind(BlockParserInterface::class, MyCustomParser::class);
$this->app->bind(DocRendererInterface::class, MyCustomRenderer::class);
```

---

## 📄 License

MIT © Mantas Tautvaiša

