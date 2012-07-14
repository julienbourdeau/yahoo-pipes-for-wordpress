Yahoo Pipes for Wordpress
=========================

This plugin create a new widget that generate a list of article from a Yahoo Pipe (json format only).
I wrote this plugin thinking about my needs, I use yahoo pipe to merge many RSS feeds from my blogs.

The markup is pretty nice.

## Markup example

```html
<aside id="ypfwp-yahoo-pipe-widget-2" class="widget ypfwp-yahoo-pipe-widget">
	<div id="main-pipe">
		<ul class="postlinkslist">	

        	<li class="web-src-icon post-hit-net item-1">
    			<a href="http://feedproxy.google.com/~r/posthit/~3/rg_eoqZVriE/installer-son-propre-serveur-git-remplacer-github">
                	<div class="web-src-icon"></div>
                    Installer son propre serveur Git pour remplacer GitHub                    <span class=""> - <small>11 days ago</small></span>
                </a>
            </li>
    
		
        	<li class="web-src-icon post-hit-net item-2">
            	
    			<a href="http://feedproxy.google.com/~r/posthit/~3/XfcoLofSt28/vsftpd-configurer-serveur-ftp-utilisateurs-virtuels-chroot-mount-bind">
                	<div class="web-src-icon"></div>
                    VSFTPD: configurer son serveur FTP avec des utilisateurs virtuels                    <span class=""> - <small>21 days ago</small></span>
                </a>
            </li>

            [...]

		</ul>
    </div>
</aside>
```

## Note about your pipe

You have to provide *the json format* link only.