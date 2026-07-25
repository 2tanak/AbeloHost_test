1. step-1: setup-docker

---

2. step-2: create patern mvc

---

3. step-3: create patern template

---

4. step-4: create models:<br>commit-1 patern singleton<br>commit-2 patern builder(подключение к сиглетоне-база и запросы цепочки<br>commit-3 create model-category<br>commit-4 create model-article(post)

---

5. step-5: Making a database query to fetch content for the homepage<br> So, we are fetching three posts linked to each category.<br>commit-1: group the flat array to get an array where each element is a category containing a nested posts array

---

6. "step-6:"
   <br>node compiles css, css is connected in the header

---

7. "step-7 Designing home page:"<br>Commit-1 - Верстаем меню,Designing the menu<br>Commit-2 - Верстаем главную страницу,Designing the home page
<br>Commit-3 - дороботка верстки.dorobotka verstka
---

8. step-8 homepage_dynamic_loop:
   <br>commit-1 - вставил карточку статьи в цикл в шаблоне home.
   I inserted the article card into the loop in the home template
   <br>commit-2 - заменяем содержимое карточки на динамические текста.Replacing the card content with dynamic text.
------------------------------------------

9. step-9 Object-Relational-Mapping: написал полноценый ORM как в Laravel:
<br>commit-1 - создал метод select, get и магический метод tostring
<br>commit-2 - создал метод has для выборки не пустых категорий.Created the has method for selecting non-empty categories
<br>commit-3 - метод where
<br>commit-4 - Реализация жадной загрузки как а Laravel пlinking 3 posts to a category .Implementing a greedy download as a Laravel.
<br>commit-5 - Метод пагинации.The pagination method
---------------------------

10. step-10 <br>commit-1 - add automatic CSS cache busting using filemtime. Чтобы браузер не кешировал css, зарегал кастомный плагин
<br>commit-2 - I finished working on the main page.закончил работать над главной страницей
---------------------

11. start page category <br>commit-1 - create path and CategoryController.
<br>commit-2 - Requesting category articles.Запрашиваем статьи категории
<br>commit-3 - The name and description of the category were displayed. Вывели название и описание категории
<br>commit-4 - sort by date and views
<br>commit-5 - page-by-page pagination
-------------------------------------------

12. page articles
<br>commit-1 - Create ArticlesController, verstka
<br>commit-2 - Делаем запрос в базу для вывода статьи. Making a request to the database for the output of the article