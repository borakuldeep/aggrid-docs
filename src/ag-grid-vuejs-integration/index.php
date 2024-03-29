<?php

$pageTitle = "Using VueJS Components in ag-Grid";
$pageDescription = "Using VueJS Components in ag-Grid";
$pageKeyboards = "VueJS Vue Component ag-Grid";

include('../includes/mediaHeader.php');
?>

<link inline rel="stylesheet" href="../documentation-main/documentation.css">
<script src="../documentation-main/documentation.js"></script>


<div class="row">
    <div class="col-md-12" style="padding-top: 20px; padding-bottom: 20px;">
        <h1><img src="../images/vue_large.png"/> Using VueJS Components in ag-Grid</h1>
    </div>
</div>

<div class="row" ng-app="documentation">
    <div class="col-md-9">

        <h2>VueJS</h2>

        <p>VueJS is a fantastic framework that has experienced amazing growth since it was first released in early 2014.
            We here at ag-Grid are proud to be able to announce support for VueJS, offering native support of VueJS components
        within the grid itself.</p>

        <p>We'll walk through creating a simple VueJS application with ag-Grid at it's core, using VueJS components to add dynamic
        functionality to the experience, making good use of what VueJS and ag-Grid offers us.</p>

        <p>The application we're going to develop is a </p>


        <img src="../images/git_current_cmd_line.png" style="width: 100%;padding-bottom: 10px">

        <p>At a glance I can seee who I'm logged in as (<code>seanlandsman</code>), which host I'm on (<code>MPB</code>),
            the current directory (<code>ag-grid-dev</code>), what branch (<code>master</code>), the
            number of modified files (<code>+1</code>) and the number of untracked files (<code>+1</code>).</p>

        <p>If I happened to be in a non-Git controlled directory then the branch and file status information would not be shown.</p>

        <h1>Adding Colour to Git - The Basics</h1>

        <p>
            You can add colour to Git output by modifying <code>~/.gitconfig</code>. The following will add colour to the main
            Git commands:
        </p>

        <pre>
[color]
    branch = auto
    diff = auto
    status = auto
[color "branch"]
    current = yellow reverse
    local = yellow
    remote = green
[color "diff"]
    meta = yellow bold
    frag = magenta bold
    old = red bold
    new = green bold
[color "status"]
    added = yellow
    changed = green
    untracked = cyan
</pre>

        <img src="../images/git_status.png" style="width: 100%;padding-bottom: 10px">

        <p>This is great and already helps visually distinguish between the different pieces of information - a good start!</p>

        <h1>Information...Without Asking</h1>

        <p>The above helps, but relies us executing Git commands to get the current state of play. This is fine of course,
            but if like me you'd like a gentle reminder of what's going on, and where you are, then we can improve on this.</p>

        <h3>bash-git-prompt</h3>

        <p><a href="https://github.com/magicmonty/bash-git-prompt" target="_blank"><code>bash-git-prompt</code></a> is a shell
            script maintained by Martin Gondermann which adds information to the command line for us.</p>

        <note>As with any any executable from the web there is a risk. I've read through the script and am happy with what it's
            doing, but please ensure you're happy with it before trying this too!</note>

        <p>You can install this either via Git clone, or via Homebrew. I work primarily on OSX and found the cloning method
            easier, but both should work.</p>

        <pre>cd ~
git clone https://github.com/magicmonty/bash-git-prompt.git .bash-git-prompt --depth=1</pre>

        <p>This will create a directory within your home directory called <code>.bash-git-prompt</code>, which does the work of
            executing Git status commands and returning the results in a format with icons and colours - all of which is
            configurable.</p>

        <p>Next we need to ensure the script is run when we're in the terminal. Add the following to ~/.bashrc:</p>

        <pre>GIT_PROMPT_ONLY_IN_REPO=1
source ~/.bash-git-prompt/gitprompt.sh</pre>

        <p><code>GIT_PROMPT_ONLY_IN_REPO=1</code> will ensure that the Git output will only be done in Git managed directories.</p>

        <p>As the terminal opens a login shell, your <code>.bashrc</code> may not get excuted in new windows. While experimenting
            you may want to add this to your <code>.bash_profile</code> to ensure your changes are picked up each time you open a
            new terminal window:</p>

        <pre>[[ -s ~/.bashrc ]] && source ~/.bashrc</pre>

        <p>The default configuration would give you an output something like this:</p>

        <img src="../images/get_default_output.png" style="width: 100%;padding-bottom: 10px">

        <p>This is a good start, but all of this is configurable. For my use case I'd prefer to keep the output a little
            terser, partly as when I'm working exclusively on my laptop screen real estate becomes a premium.</p>

        <p>I also (occasionally) work on remote hosts and it's a good reminder to know what and who I am when I'm there,
            so I'd like to have this shown too.</p>

        <p>Finally, although nice I don't really need to know the status of the last command excuted (the little green tick at the
            start indicates this).</p>

        <p>Themes are how <code>bash-git-prompt</code> allows for user configuration
            of the output. There are a number of themes provide with <code>bash-git-prompt</code> and I'd encourage you to try them
            to see what's possible, but in my case I decided to tweak the output to something bespoke.</p>

        <pre>git_prompt_make_custom_theme Default</pre>

        <p>The above will create a new theme file (<code>~/.git-prompt-colors.sh</code>) based on the Default theme.</p>

        <p>I won't list the entire file contents here, but will highlight the parts I've changed:</p>

        <pre>
<span class="codeComment">// just the current directory name - not the full path</span>
PathShort="\W";

<span class="codeComment">// round brackets surround the Git output</span>
<span class="codeComment">// I prefer them to square brackets - I couldn't tell you why ;-)</span>
GIT_PROMPT_PREFIX="("                 # start of the git info string
GIT_PROMPT_SUFFIX=")"                 # the end of the git info string

<span class="codeComment">// change a couple of the colours to be inline with what I've configured in Git</span>
GIT_PROMPT_CHANGED="${Green}✚ "        # the number of changed files
GIT_PROMPT_UNTRACKED="${Red}…"       # the number of untracked files/dirs

<span class="codeComment">// The pre-Git output - show username@host current-directory</span>
<span class="codeComment">// This information will be displayed all the time, even if not in a Git controlled directory</span>
GIT_PROMPT_START_USER="${USER}@${HOSTNAME} ${Yellow}${PathShort}${ResetColor}"
</pre>

        <p>That's it! With these small changes in place I'm done - I have the output I wanted with very little configuration.</p>

        <p>I encourage you to give this a go, and experiment with the provided themes - you may find one of them already
            does want you want. I'd also encourage you to read the docs in the <a
                href="https://github.com/magicmonty/bash-git-prompt">bash-git-prompt</a> page - there's a lot of good information
            there.</p>

        <div style="margin-top: 20px;">
            <a href="https://twitter.com/share" class="twitter-share-button"
               data-url="https://www.ag-grid.com/ag-grid-vuejs-integration/"
               data-text="Using VueJS Components in ag-Grid" data-via="seanlandsman"
               data-size="large">Tweet</a>
            <script>!function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = p + '://platform.twitter.com/widgets.js';
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, 'script', 'twitter-wjs');</script>
        </div>

    </div>
    <div class="col-md-3">

        <div>
            <a href="https://twitter.com/share" class="twitter-share-button"
               data-url="https://www.ag-grid.com/ag-grid-vuejs-integration/"
               data-text="Using VueJS Components in ag-Grid" data-via="seanlandsman"
               data-size="large">Tweet</a>
            <script>!function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = p + '://platform.twitter.com/widgets.js';
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, 'script', 'twitter-wjs');</script>
        </div>

        <div style="font-size: 14px; background-color: #dddddd; padding: 15px;">

            <p><img src="../images/sean.png"/></p>
            <p style="font-weight: bold;">
                Sean Landsman
            </p>
            <p>
                I'm an experienced full stack technical lead with an extensive background in enterprise solutions. Over
                19 years in the industry has taught me the value of quality code and good team collaboration. The bulk
                of my background is on the server side, but like Niall am increasingly switching focus to include front
                end
                technologies.
            </p>
            <p>
                Currently work on ag-Grid full time.
            </p>

            <div>
                <br/>
                <a href="https://www.linkedin.com/in/sean-landsman-9780092"><img src="/images/linked-in.png"/></a>
                <br/>
                <br/>
                <a href="https://twitter.com/seanlandsman" class="twitter-follow-button" data-show-count="false"
                   data-size="large">@seanlandsman</a>
                <script>!function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                        if (!d.getElementById(id)) {
                            js = d.createElement(s);
                            js.id = id;
                            js.src = p + '://platform.twitter.com/widgets.js';
                            fjs.parentNode.insertBefore(js, fjs);
                        }
                    }(document, 'script', 'twitter-wjs');</script>
            </div>

        </div>

    </div>
</div>


<hr/>

<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = 'aggrid';

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function () {
        var dsq = document.createElement('script');
        dsq.type = 'text/javascript';
        dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments
        powered by Disqus.</a></noscript>
<hr/>

<footer class="license">
    © ag-Grid Ltd 2015-2016
</footer>

<?php
include('../includes/mediaFooter.php');
?>
