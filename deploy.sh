chmod 600 /tmp/nuclearnetwork_travis
eval "$(ssh-agent -s)" # Start the ssh agent
ssh-add /tmp/nuclearnetwork_travis
git remote add nuclearnetwork_wp git@git.wpengine.com:staging/nuclearnetwork.git # add remote for staging site
git fetch --unshallow # fetch all repo history or wpengine complain
git status # check git status
git checkout master # switch to master branch
git add wp-content/themes/nuclearnetwork/*.css -f # force all compiled CSS files to be added
git commit -m "compiled assets" # commit the compiled CSS files
git push -f nuclearnetwork_wp master:master #deploy to staging site from master to master