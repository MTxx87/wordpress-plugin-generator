import os, sys, argparse

def contentreplace(c, r):
    c = c.replace('Blank Plugin', r['name'])
    c = c.replace('blank-plugin', r['dashed'])
    c = c.replace('blank_plugin', r['underscored'])
    c = c.replace('blankplugin', r['joined'])
    c = c.replace('Blank_Plugin', r['classname'])
    c = c.replace('BlankPlugin', r['classinstance'])
    c = c.replace('//[[DESCRIPTION]]//', r['description'])
    c = c.replace('//[[UPDATER]]//', r['updater'])
    return c


default_name = 'blank plugin'
mokup_dir =  '_blank-plugin'

parser = argparse.ArgumentParser(description='')
parser.add_argument('name', type=str, help='plugin name')
parser.add_argument('description', type=str, help='plugin description')
parser.add_argument('-s','--standalone', dest='git', nargs=3, help='[Git Username, Git Repo Name, Git Api Key]' )

args = parser.parse_args()
name = args.name
description = args.description
git = args.git

if not name.strip() :
  print("Empty name!")
  sys.exit(0)

if not description.strip() :
  print("Empty description!")
  sys.exit(0)

replacements = {
    'name' : name,
    'dashed' : name.lower().replace(' ', '-'),
    'underscored' : name.lower().replace(' ', '_'),
    'joined' : name.lower().replace(' ', ''),
    'classname' : name.lower().replace(' ', '_').title(),
    'classinstance' : name.lower().title().replace(' ', ''),
    'description' : description,
    'updater' : '//[[UPDATER]]//'
}

#if it is meant to be a standalone plugin, we need to include the updater
updater = ''
if git is not None:
    with open('generator-includes/updater-code.php', 'r') as updater_code:
        content = updater_code.read()
        content = content.replace('<?php','')
        content = content.replace('?>','')
        content = content.replace('//[USERNAME]//', git[0])
        content = content.replace('//[REPO]//', git[1])
        content = content.replace('//[APIKEY]//', git[2])
        content = contentreplace(content, replacements)
        updater = content

replacements['updater'] = updater

#main directory and folder structure
maindir = 'dist/' + replacements['dashed']
tree = [
    maindir,
    maindir + '/includes',
    maindir + '/languages',
    maindir + '/templates',
    maindir + '/assets',
    maindir + '/assets/js',
    maindir + '/assets/css',
]

for directory in tree:
    if not os.path.exists(directory):
        os.makedirs(directory)

#main file

files = {
    mokup_dir + '/blank-plugin.php' : maindir + '/' + replacements['dashed'] + '.php',
    mokup_dir + '/includes/blank-plugin-settings.php' : maindir + '/includes/' + replacements['dashed'] + '-settings.php',
    mokup_dir + '/assets/js/blankplugin.main.js' : maindir + '/assets/js/' + replacements['joined'] + '.main.js',
    mokup_dir + '/assets/css/blankplugin.main.css' : maindir + '/assets/css/' + replacements['joined'] + '.main.css',
    mokup_dir + '/languages/blank-plugin.pot' : maindir + '/languages/' + replacements['dashed'] + '.pot',
}

if updater != '':
    files[mokup_dir + '/includes/updater.php'] = maindir + '/includes/updater.php';

for old, new in files.iteritems():
    with open(old, 'r') as content_file:
        content = content_file.read()
    content = contentreplace(content, replacements)
    newfile = open(new,'w');
    newfile.write(content);
    newfile.close();
