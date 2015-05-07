core = 7.x
api = 2

projects[drupal][type] = core
projects[drupal][download][type] = "git"
projects[drupal][download][url] = "https://github.com/omega8cc/7x.git"
projects[drupal][download][tag] = "7.37.1"
projects[drupal][patch][] = "https://www.drupal.org/files/issues/2329453-8-ignore_node_modules_directory.patch"

projects[***MACHINE_NAME***][type] = "profile"
projects[***MACHINE_NAME***][download][type] = "kraftwagen_directory"
projects[***MACHINE_NAME***][download][url] = "**SRC_DIR**"
