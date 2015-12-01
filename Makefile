# volter9.github.io Makefile
# 
# This Makefile is responsible for:
# 
# - Build HTML static website out of PHP website
# - Commit and deploy to GitHub pages
# - Creating a post
# 
# @author volter9
# @package volter9.github.io

GIT = git -C ./build
m   = empty

title = ""
slug  = ""

.PHONY: build
all: build

# Build HTML pages
build: clean css
	vendor/bin/bloge app.php build
	
	mkdir build/assets
	cp -r assets/js build/assets/js
	cp -r assets/css build/assets/css
	cp -r assets/img build/assets/img
	cp -r assets/uploads build/assets/uploads

# Build and/or watch CSS stylesheet
css:
	lessc assets/less/main.less assets/css/main.css
	csscomb assets/css/main.css

watch_css:
	less-watch-compiler assets/less assets/css

# Commit changes to the build website
commit: build
ifeq ($(m),empty)
	echo 'Commit message should not be empty'
	exit 0
else
	$(GIT) add -u
	$(GIT) add .
	$(GIT) commit -m '$(m)'
endif

# Deploy to the server
deploy: commit
	$(GIT) push origin master

# Create post with title and URL-slug
post:
	$(PHP)post.php '$(title)' '$(slug)'

# Clean build folder
clean:
	find ./build -maxdepth 1 ! -name 'build' \
	                 ! -name '.git*' \
	                 ! -name 'README.md' \
	                   -exec rm -rf {} \;