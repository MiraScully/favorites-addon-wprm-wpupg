# favorites-addon-wprm-wpupg (minimal)
Integrates Kyle Phillips’s Favorites with **WP Recipe Maker (WPRM)** and **WP Ultimate Post Grid (WPUPG)**.

This minimal add-on lets a WPUPG grid show **only the logged-in user’s Favorites** when the GET param `only_bookmarks=1` is present.
Your normal WPUPG filters (e.g. ingredients, recipe categories) still work — just scoped to those favorites.

**Defaults:** post types `post`, `wprm_recipe` (if the grid sets `post_type`, that is respected).

## Requirements
- WordPress 6+
- Favorites (by Kyle Phillips)
- WP Ultimate Post Grid (WPUPG)
- WP Recipe Maker (WPRM) if you use recipe content

## How to use
Put a small GET form somewhere on the page that contains your WPUPG block. When the user enables it, the grid limits to their Favorites.

**English:**
<form method="get" action="">
  <label>
    <input type="checkbox" name="only_bookmarks" value="1" <?php echo isset( $_GET['only_bookmarks'] ) ? 'checked' : ''; ?>>
    Only my favorites
  </label>
  <button type="submit">Apply</button>
</form>

**Deutsch:**
<form method="get" action="">
  <label>
    <input type="checkbox" name="only_bookmarks" value="1" <?php echo isset( $_GET['only_bookmarks'] ) ? 'checked' : ''; ?>>
    Nur meine Favoriten
  </label>
  <button type="submit">Anwenden</button>
</form>

On load with `?only_bookmarks=1` (and if the user is logged in), the grid is restricted to their Favorites.
If there are no favorites for the selected post types, the grid returns no results.

## Notes
- Works for logged-in users only.
- Pagination is reset to page 1 when filtering down.
- You select the grid via the **WPUPG block in the Gutenberg editor** as usual.

## Version
0.1.0 – initial release
