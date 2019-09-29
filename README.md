---


---

<h1 id="laravel-rest-api---study-notes">Laravel REST API - Study Notes</h1>
<h2 id="introduction">Introduction</h2>
<p>These are some study notes I’ve taken as part of the PluralSight course: <a href="https://www.pluralsight.com/courses/php-laravel-restful-web-services">RESTful Web Services with PHP and Laravel</a> in conjunction with the <a href="%5Bhttps://laravel.com/docs/6.x%5D(https://laravel.com/docs/6.x)">Laravel Documentation</a></p>
<p>Credit to the author, <a href="%5Bhttps://twitter.com/maxedapps%5D(https://twitter.com/maxedapps)">Maximilian Schwarzmüller</a>, for helping me learn this Laravel knowledge and come up with these study notes.</p>
<p>If you want to try this course out for free, check out <a href="pluralsight.pxf.io/c/1940999/503634/7490">PluralSight’s Free Trial</a> to give the course a go!</p>
<h2 id="module-1-designing-and-structuring-a-restful-service">Module 1: Designing and Structuring a RESTful Service</h2>
<p>This module was more theoretical, focusing on decomposing an API idea and listing out the different endpoints that you may require.</p>
<h3 id="main-http-methods">Main HTTP Methods</h3>
<ul>
<li>GET: Retrieve a resource</li>
<li>POST: Add a resource</li>
<li>PUT: Replace a resource</li>
<li>PATCH: Update parts of a resource</li>
<li>DELETE: Remove a resource</li>
</ul>
<h3 id="api-endpoint-examples">API Endpoint Examples</h3>
<p>Below is an example of the different API endpoints on the project worked on in the course.</p>
<p><strong>GET</strong><br>
Get List of all Meetings<br>
Get Data about Individual Meetings</p>
<p><strong>POST</strong><br>
Create Meeting<br>
Register for Meeting<br>
Create User<br>
User Signin</p>
<p><strong>PUT</strong><br>
Update Meeting</p>
<h2 id="module-2-routing">Module 2: Routing</h2>
<h3 id="creating-a-route">Creating a Route</h3>
<p>Below is an example of a POST route, accessible via the ‘/post’ path. This example triggers the create method in the PostController controller. The name of this route is set to post.create. If needed, middleware can be specified, and in this example, the auth middleware is set.</p>
<pre class=" language-php"><code class="prism  language-php">Route<span class="token punctuation">:</span><span class="token punctuation">:</span><span class="token function">post</span><span class="token punctuation">(</span><span class="token string">'/post'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
	<span class="token string">'uses'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'PostController@create'</span><span class="token punctuation">,</span>
	<span class="token string">'as'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'post.create'</span><span class="token punctuation">,</span>
	<span class="token string">'middleware'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'auth'</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre>
<h3 id="creating-restful-routes">Creating RESTful Routes</h3>
<p>Above shows the way to create a traditional route, however with a RESTful API, we may need many different routes to handle different actions.<br>
Although these can be configured manually, Laravel offers a way to generate multiple routes easily.</p>
<p>The resource() method will create multiple routes for us, which are linked to different controller actions in the specified controller.</p>
<pre class=" language-php"><code class="prism  language-php">Route<span class="token punctuation">:</span><span class="token punctuation">:</span><span class="token function">resource</span><span class="token punctuation">(</span><span class="token string">'post'</span><span class="token punctuation">,</span> <span class="token string">'PostController'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre>
<p>These are the following routes which are created with the resource method:</p>
<pre><code>| HTTP Method &amp; URL  | Controller Action |
| ------------- | ------------- |
| GET /post  | index [show all posts]  |
| GET /post/create  | create [get creation form]  |
| POST /post  | store [store post on server]  |
| GET /post/{post}  | show [get single post] |
| GET /post/{post}/edit  | edit [get edit form]  |
| PUT/PATCH /post/{post}  | update [save update on server]  |
| DELETE /post/{post}  | destroy [delete post on server] |
</code></pre>
<h3 id="creating-restful-controllers">Creating RESTful Controllers</h3>
<p>The different RESTful routes which were created in the previous section link to various controller actions. To set up the controller along with the RESTful controller actions, use the following command:</p>
<pre class=" language-php"><code class="prism  language-php">php artisan make<span class="token punctuation">:</span>controller PostController <span class="token operator">--</span>resource
</code></pre>
<p>The command creates a controller as normal, but the <strong>–resource</strong> flag populates the controller with the methods that are expected by the RESTful route created earlier.</p>
<h3 id="route-grouping">Route Grouping</h3>
<p>Often you may have multiple routes which you want to have the same prefix. For example, let’s take the following prefix: <em>api/v1</em>.<br>
If we want all of our routes to contain this prefix, the following method will help us achieve this without repeating ourself upon the creation of each of these routes:</p>
<pre class=" language-php"><code class="prism  language-php"><span class="token comment">// State the prefix you want for the contained routes</span>
Route<span class="token punctuation">:</span><span class="token punctuation">:</span><span class="token function">group</span><span class="token punctuation">(</span><span class="token punctuation">[</span><span class="token string">'prefix'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'api/v1'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
	<span class="token comment">// Place any routes in here</span>
	Route<span class="token punctuation">:</span><span class="token punctuation">:</span><span class="token function">post</span><span class="token punctuation">(</span><span class="token string">'/post'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre>
<h2 id="module-3-request-handling-and-responses">Module 3: Request Handling and Responses</h2>
<h3 id="sending-requests-and-getting-a-response">Sending Requests and Getting a Response</h3>
<p>The general path for a request in Laravel is as follows:</p>
<blockquote>
<p>Client -&gt; Router -&gt; Middleware -&gt; Controller</p>
</blockquote>
<ul>
<li><strong>Client</strong>: The user making the request to our application.</li>
<li><strong>Router</strong>: The <strong>Laravel Router</strong> which will appropriately handle the request, by pointing it towards the correct controller.</li>
<li><strong>Middleware</strong>: Requirements that must be fulfilled before reaching the controller. This can prevent unauthorised users from accessing certain parts of an application, for example, an area of the website which requires you to be logged in.</li>
<li><strong>Controller</strong>: The endpoint of a request, where the desired action is performed on the request and returned.</li>
</ul>
<h3 id="accessing-input">Accessing Input</h3>
<p>Inputs can be retrieved from the <strong>Request</strong> object (Illuminate\Http\Request).<br>
For example,  from some JSON data, an input with the name ‘title’ can be accessed via the following:</p>
<pre class=" language-php"><code class="prism  language-php"><span class="token variable">$title</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">input</span><span class="token punctuation">(</span><span class="token string">'title'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre>
<h3 id="responses">Responses</h3>
<p>Common responses from a controller can include a HTML pages, JSON, a file, or plain text.</p>
<h3 id="returning-a-response">Returning a response</h3>
<p>Amongst all of the different responses that can be sent back to the user, JSON is very common.<br>
Laravel has a built-in JSON method which will convert a PHP associative array into the respective JSON format. This is achieved using the built in <strong>json_encode</strong> PHP function.</p>
<pre class=" language-php"><code class="prism  language-php"><span class="token keyword">return</span> <span class="token function">response</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">json</span><span class="token punctuation">(</span><span class="token variable">$associativeArray</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre>
<p><strong>General things to include in a response:</strong></p>
<ul>
<li><strong>Message</strong>: Success or failure of the request made by the user, with a description of what is being achieved. This is so the user knows exactly what has happened with their request.</li>
<li><strong>Data</strong>: Any data associated with the request being made. For example, if a user has created a new post, you could include the title of it to confirm the new post has been created.</li>
<li><strong>Link</strong>: A link to the resource which is related to the request that is made. This is so the user can access their newly created resource.</li>
</ul>
<h3 id="validation">Validation</h3>
<p>Laravel has a built-in validator, which can validate any data that comes through a request.<br>
The <strong>validate</strong> method is used, which specifies the different rules that should be followed for the different inputs from a given request.<br>
Parameters:</p>
<ol>
<li><strong>Request</strong>: The request which the data needs to be validated for</li>
<li><strong>Associative Array</strong>: an associative array specifying the validation rules</li>
</ol>
<pre class=" language-php"><code class="prism  language-php"><span class="token variable">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">validate</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
	<span class="token string">'title'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required|max:120'</span><span class="token punctuation">,</span>
	<span class="token string">'content'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required'</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre>
<h2 id="module-4-crud-operations">Module 4: CRUD Operations</h2>
<h3 id="creating-models-and-migrations">Creating Models and Migrations</h3>
<p><strong>Models</strong>: Classes which are used to interact with a corresponding database.</p>
<blockquote>
<p>For example, a ‘Post’ model could be used to interact with a ‘posts’ database table.</p>
</blockquote>
<p><strong>Migrations</strong>: Files which handle the creation and configuration of database tables.</p>
<h3 id="artisan-commands-for-models-and-migrations">Artisan Commands for Models and Migrations</h3>
<p>Query 1: Creating a model, with a corresponding migration file (-m).<br>
Query 2: Creates a migration file separate to any model creation.</p>
<pre class=" language-php"><code class="prism  language-php">Query <span class="token number">1</span><span class="token punctuation">:</span> php artisan make<span class="token punctuation">:</span>model Post <span class="token operator">-</span>m
Query <span class="token number">2</span><span class="token punctuation">:</span> php artisan make<span class="token punctuation">:</span>migration PostTableMigration
</code></pre>
<h3 id="configuring-a-database-table">Configuring a Database Table</h3>
<p>Configurations for a database table are held in the <strong>up()</strong> method.<br>
In here, you can define the various fields you would like your table to have. Example:</p>
<pre class=" language-php"><code class="prism  language-php"><span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">dateTime</span><span class="token punctuation">(</span><span class="token string">'time'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string</span><span class="token punctuation">(</span><span class="token string">'title'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">text</span><span class="token punctuation">(</span><span class="token string">'description'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre>
<p>Once you have configured your migration files to reflect the database table you want to create, run the following command, which will <strong>create</strong> the tables in the database:</p>
<pre class=" language-php"><code class="prism  language-php">php artisan migrate
</code></pre>
<h3 id="defining-relations">Defining Relations</h3>
<p>Once your models have been created, stored in the <strong>App</strong> folder, you can set up relations between them.</p>
<p>Example: Let’s take the relationship between a <strong>Post</strong> and a <strong>Comment</strong>.<br>
A Post could have many comments. To define this relationship in Laravel, you define the following function in the <strong>Post</strong> model:</p>
<pre class=" language-php"><code class="prism  language-php"><span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">comments</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
	<span class="token comment">// Passing in the name of the related model into the hasMany method</span>
	<span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hasMany</span><span class="token punctuation">(</span><span class="token string">'App\Comment'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>
</code></pre>
<p>On the other side of the relationship, a Comment can only belong to one particular post. To define this relationship in Laravel, you define the following function in the <strong>Comment</strong> model:</p>
<pre class=" language-php"><code class="prism  language-php"><span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">post</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
	<span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsTo</span><span class="token punctuation">(</span><span class="token string">'App\Post'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>
</code></pre>
<h3 id="interacting-with-data---one-to-many">Interacting With Data - One to Many</h3>
<p>Below is an example of finding a Post, and adding a Comment to it.</p>
<pre class=" language-php"><code class="prism  language-php"><span class="token comment">// Retrieving the post you want, by ID</span>
<span class="token variable">$post</span> <span class="token operator">=</span> Post<span class="token punctuation">:</span><span class="token punctuation">:</span><span class="token function">find</span><span class="token punctuation">(</span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Initialising a new Comment model, with the related data</span>
<span class="token variable">$comment</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Comment</span><span class="token punctuation">(</span>data<span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Calling the comments() method on the Post model, to store the comment in relation to the post that has been retrieved. </span>
<span class="token comment">// Laravel auto-generates the post_id foreign key entry in the database for this comment.</span>
<span class="token variable">$post</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">comments</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save</span><span class="token punctuation">(</span><span class="token variable">$comments</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre>
<h3 id="interacting-with-data---many-to-many">Interacting With Data - Many to Many</h3>
<p>The process is similar between models which have a many to many relationship, but instead you use the attach method. Attach ensures that the foreign key entry is not only created in the related model’s table, but also in the pivot table. Below is an example:</p>
<pre class=" language-php"><code class="prism  language-php"><span class="token variable">$post</span> <span class="token operator">=</span> Post<span class="token punctuation">:</span><span class="token punctuation">:</span><span class="token function">find</span><span class="token punctuation">(</span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$user</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">User</span><span class="token punctuation">(</span>data<span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$post</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">users</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">attach</span><span class="token punctuation">(</span><span class="token variable">$user</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre>
<h3 id="interacting-with-data----eloquent-methods">Interacting with Data  - Eloquent Methods</h3>
<p>As I completed the implementation of this section of the course, many different methods were used when interacting with data in relation to the databases. Below, I’ve tried to summarise some of the important ones that were used:</p>
<pre class=" language-php"><code class="prism  language-php"><span class="token comment">// The notes refer to a 'Model', which can be any model you may be working with in Laravel. </span>

<span class="token comment">// Storing a model in the database</span>
<span class="token comment">/* The method will return true upon success, which can be used to determine the actions to take when a record has been inserted. */</span>
<span class="token variable">$model</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save</span><span class="token punctuation">(</span><span class="token punctuation">)</span>

<span class="token comment">// Retrieving all of the models from the database</span>
<span class="token variable">$models</span> <span class="token operator">=</span> Model<span class="token punctuation">:</span><span class="token punctuation">:</span><span class="token function">all</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Let model = meeting, relatedModels = users</span>
<span class="token comment">/* A meeting can have one or more users, and a user can be registered for one or more meetings.
The attach metod adds the entry for this many to many relationship in the pivot table. */</span>
<span class="token variable">$model</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">relatedModels</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">attach</span><span class="token punctuation">(</span><span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Get all of the data for the specified model, as well as the defined relatedModel defined</span>
<span class="token variable">$model</span> <span class="token operator">=</span> Model<span class="token punctuation">:</span><span class="token punctuation">:</span><span class="token function">with</span><span class="token punctuation">(</span><span class="token string">'relatedModel'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Retrieves the first result of a query, or will otherwise throw an exception. A 404 HTTP response is automatically generated and sent back to the user.</span>
<span class="token variable">$model</span> <span class="token operator">=</span> Model<span class="token punctuation">:</span><span class="token punctuation">:</span><span class="token function">findOrFail</span><span class="token punctuation">(</span><span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Removes the entry in the pivot table between models which have a many to many relationship.</span>
<span class="token variable">$model</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">relatedModels</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">detach</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre>
<h1 id="module-5-authentication">Module 5: Authentication</h1>
<h2 id="introduction-1">Introduction</h2>
<p>Authentication with a RESTful service is a bit different to the usual application that you may build.</p>
<p>RESTful Services are Stateless, meaning you cannot store a session. This is a general characteristic of REST.</p>
<p>A solution is to have a token which the server can authenticate as being valid. This isn’t stored on the server, but the processing of such tokens will occur on the server.</p>
<p><em>Note: Due to having some setup issues with JWT following the tutorial, I decided not to carry on working on the module.<br>
If possible, I plan to come back to the module to take the time to work through the issues I was facing.</em></p>

