core = 7.x
api = 2

projects[kw_manifests][type]            = "module"
projects[kw_manifests][download][type]  = "git"
projects[kw_manifests][download][url]   = "git://github.com/kraftwagen/kw-manifests.git"
projects[kw_manifests][subdir]          = "kraftwagen"

projects[kw_itemnames][type]            = "module"
projects[kw_itemnames][download][type]  = "git"
projects[kw_itemnames][download][url]   = "git://github.com/kraftwagen/kw-itemnames.git"
projects[kw_itemnames][subdir]          = "kraftwagen"

projects[token][version]            = "1.5"
projects[token][subdir]             = "contrib"

projects[entity][version]           = "1.2"
projects[entity][subdir]            = "contrib"

projects[ctools][version]           = "1.4"
projects[ctools][subdir]            = "contrib"

projects[features][version]         = "2.0"
projects[features][subdir]          = "contrib"

projects[strongarm][version]        = "2.0"
projects[strongarm][subdir]         = "contrib"

projects[transliteration][version]  = "3.1"
projects[transliteration][subdir]   = "contrib"

projects[pathauto][version]         = "1.2"
projects[pathauto][subdir]          = "contrib"

projects[views][version]            = "3.7"
projects[views][subdir]             = "contrib"

projects[panelizer][version]        = "3.1"
projects[panelizer][subdir]         = "contrib"

projects[panels][version]           = "3.4"
projects[panels][subdir]            = "contrib"

projects[local_tasks_blocks][version] = "2.2"
projects[local_tasks_blocks][subdir]  = "contrib"

projects[link][version]             = "1.2"
projects[link][subdir]              = "contrib"

projects[paragraphs][version]       = "1.0-beta1"
projects[paragraphs][subdir]        = "contrib"

projects[smart_trim][version]       = "1.4"
projects[smart_trim][subdir]        = "contrib"

projects[field_group][version]      = "1.1"
projects[field_group][subdir]       = "contrib"

projects[linkit][version]           = "2.6"
projects[linkit][subdir]            = "contrib"

projects[module_filter][version]    = "1.8"
projects[module_filter][subdir]     = "contrib"

projects[xmlsitemap][version]       = "2.0-rc2"
projects[xmlsitemap][subdir]        = "contrib"

projects[metatag][version]          = "1.0-beta7"
projects[metatag][subdir]           = "contrib"

projects[jquery_update][version]    = "2.3"
projects[jquery_update][subdir]     = "contrib"

projects[date][version]             = "2.7"
projects[date][subdir]              = "contrib"

projects[google_analytics][version] = "1.3"
projects[google_analytics][subdir]  = "contrib"

projects[backup_migrate][version]   = "2.8"
projects[backup_migrate][subdir]    = "contrib"

projects[metatag][version]          = "1.0-beta9"
projects[metatag][subdir]           = "contrib"

projects[redirect][version]         = "1.0-rc1"
projects[redirect][subdir]          = "contrib"

projects[globalredirect][version]   = "1.5"
projects[globalredirect][subdir]    = "contrib"

projects[ckeditor][version]         = "1.13"
projects[ckeditor][subdir]          = "contrib"

projects[role_delegation][version]  = "1.1"
projects[role_delegation][subdir]   = "contrib"

projects[devel][subdir]             = "contrib"

projects[diff][subdir]              = "contrib"

libraries[ckeditor][download][type] = "file"
libraries[ckeditor][download][url] = http://download.cksource.com/CKEditor/CKEditor/CKEditor%204.3/ckeditor_4.3_full.zip

# Includes for custom modules.
includes[***MACHINE_NAME***_locale] = modules/custom/***MACHINE_NAME***_locale/***MACHINE_NAME***_locale.make
