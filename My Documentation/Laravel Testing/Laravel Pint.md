Laravel **Pint** is Laravel’s official **PHP code style fixer**. It’s built on top of [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer), but it’s pre-configured with Laravel’s own coding style, so you get consistent, clean, and framework-friendly formatting automatically.

Here’s a breakdown of how to use it effectively:

---

## 📦 Installation

If you’re using Laravel 9.21+ it comes pre-installed.
Otherwise, you can install it via Composer:

```bash
composer require laravel/pint --dev
```

---

## 🚀 Running Pint

1. **Check and fix all files**

   ```bash
   ./vendor/bin/pint
   ```

   or if you installed globally via `composer global require laravel/pint`:

   ```bash
   pint
   ```

   👉 This will scan your project and fix code style issues according to Laravel’s standards.

---

2. **Check specific files/directories**

   ```bash
   pint app/Models
   pint routes/web.php
   ```

---

3. **Dry run (only show errors, don’t fix)**

   ```bash
   pint --test
   ```

   ✅ Useful in CI/CD pipelines to ensure style consistency.

---

4. **Run in verbose mode (see what’s changed)**

   ```bash
   pint -v
   ```

---

5. **Use different presets**
   Laravel Pint has presets like `laravel`, `psr12`, `symfony`, etc.

   ```bash
   pint --preset=psr12
   ```

   👉 Default preset is `laravel`.

---

6. **Configuration file**
   You can customize Pint with a `pint.json` file at the root of your project:

   ```json
   {
       "preset": "laravel",
       "rules": {
           "strict_param": true,
           "no_unused_imports": true
       }
   }
   ```

   ✅ This way, you can override or extend Pint’s defaults.

---

7. **Git Hook (auto-fix before commit)**
   You can automate Pint using a `pre-commit` Git hook:

   ```bash
   npx husky add .husky/pre-commit "vendor/bin/pint"
   ```

   This ensures every commit has clean code.

---

## 💡 Best Practices

* Run Pint **before committing/pushing code** (`pint`).
* Add a **CI step** with `pint --test` to block style violations.
* Customize `pint.json` if your team wants stricter or looser rules.


Pint is **very useful** in real-world Laravel projects.
It’s not just about “nice formatting” — it ensures **consistent, predictable, and clean code style across the team**, which saves hours of code review debates, prevents subtle bugs, and makes your codebase much easier to maintain long-term.

Think of it like **PHPStan/Psalm for style**: while static analyzers catch logical bugs, Pint enforces **readability and conventions**.

---

# ✅ Why Pint is useful

* **Consistency across teams** – Everyone writes code the same way, no matter their personal style.
* **Clean diffs in Git** – Fewer “noise changes” (extra spaces, wrong braces, etc.).
* **Automatic fixes** – Instead of nitpicking in PR reviews, Pint just corrects things.
* **Framework-friendly defaults** – It enforces Laravel’s style guide by default (much better than plain PSR-12).
* **CI/CD Integration** – You can block merges with bad formatting using `pint --test`.

---

# 🔍 What Pint Checks (Rules)

Pint is built on top of **PHP-CS-Fixer**, so it inherits all its rules.
Laravel maintains its own **preset (`laravel`)**, which includes the most important ones.

Here’s a categorized breakdown of what Pint checks (with the Laravel preset + optional rules):

---

## 🎨 Formatting & Layout

* **Indentation** → 4 spaces (never tabs).
* **Line endings** → Unix (`\n`).
* **No trailing spaces** at the end of lines.
* **Blank lines**:

   * Remove multiple blank lines.
   * Add a blank line before `return`, after namespace/use statements.
* **Braces**:

   * PSR-12 style: open braces on the same line.
* **Trailing commas** in multi-line arrays.
* **Array indentation** and alignment.

---

## 📦 Imports & Namespaces

* **Order imports alphabetically**.
* **Remove unused imports** (`use` statements).
* **Group imports consistently**.
* **Normalize namespaces** (no leading `\`, no redundant parts).

---

## 🔤 Strings

* Use **single quotes `' '`** when no interpolation is needed.
* Use **double quotes `" "`** only if variables or escape sequences are inside.
* **Heredoc/Nowdoc formatting** normalized.

---

## 🔢 Numbers, Constants & Booleans

* **Lowercase booleans** (`true`, `false`, `null`).
* **Short array syntax** (`[]` not `array()`).
* **Numeric literal separator** enforcement (e.g., `1_000_000` for readability if enabled).
* **No leading zeros** in integers.

---

## 🧩 Functions & Methods

* **Space after `function` keyword**.
* **Consistent function declaration style**.
* **Type hints spacing** (`function foo(int $x): string`).
* **Nullable types normalized** (`?string` not `string|null`).
* **No extra spaces** inside parentheses.
* **Method argument alignment** in multi-line.

---

## 🏗 Classes, Traits & Interfaces

* **Class declaration spacing**:

   * 1 blank line after namespace/use statements.
   * No blank lines after opening brace.
* **Visibility declared for methods & properties** (public/protected/private).
* **Order of class elements** (constants, properties, methods).
* **Final/public/static placement normalized**.
* **Trait import formatting** (`use TraitName;` one per line if multiple).

---

## 🗂 PHPDocs & Comments

* **Remove useless PHPDocs** (`@param int $x` if type already declared).
* **Align PHPDoc annotations**.
* **Consistent casing** in annotations (`@var`, `@return`).
* **No empty comments**.
* **No redundant inheritdoc**.

---

## ⚡ Code Style Optimizations

* **No unused variables**.
* **No extra semicolons**.
* **No `==` or `!=`** (force `===` and `!==`).
* **No yoda conditions** (`$a === 1` not `1 === $a`).
* **No short PHP open tags** (`<?` → `<?php`).
* **Concatenation spacing** (`'a' . 'b'` not `'a'.'b'`).
* **Logical operator normalization** (`and/or` → `&&/||`).
* **Control structure braces** always required (`if`, `for`, `foreach`, etc.).

---

# ⚙️ Example `pint.json` (Extended Best Rules)

Here’s a production-grade config that goes beyond Laravel defaults:

```json
{
    "preset": "laravel",
    "rules": {
        "strict_comparison": true,
        "strict_param": true,
        "no_unused_imports": true,
        "no_useless_return": true,
        "no_useless_else": true,
        "single_quote": true,
        "no_extra_blank_lines": true,
        "no_trailing_whitespace": true,
        "ordered_imports": { "sort_algorithm": "alpha" },
        "class_attributes_separation": {
            "elements": ["method", "property"]
        },
        "phpdoc_no_useless_inheritdoc": true,
        "phpdoc_trim": true,
        "phpdoc_align": true,
        "nullable_type_declaration_for_default_null_value": true
    }
}
```

---

👉 So in short: **Pint enforces code cleanliness, Laravel conventions, and PSR-12** while removing human subjectivity.