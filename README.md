# wordpress-plugin-generator
Python script to generate basic scaffolding of a WP plugin

# usage

1. `git clone https://github.com/MTxx87/wordpress-plugin-generator.git`
2. `cd wordpress-plugin-generator`
3. `python generator.py "Plugin XYZ" "Plugin XYZ Description"`
4. the plugin code is generated inside `/dist` folder

# options

Option | Description
--- | ---
-h | shows help
-s | Includes git updater (enables plugin to be updated from Github repo). Requires three parameters: Username, Repo Name, Git Api Key. Eg: `python generator.py "Plugin" "Plugin description" -s username my-repo gitapikey`
