<?php
ob_start();
?>
<div class="backbutton" >
    <ul>
        <li onclick="closecategory()"><svg xmlns="http://www.w3.org/2000/svg" height="34px" viewBox="0 -960 960 960" width="34px" fill="#404040"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg><a href="#"></a></li>
    </ul>
</div>
<div class="menubutton" >
    <ul>
        <li onclick="showcategory()"><svg xmlns="http://www.w3.org/2000/svg" height="34px" viewBox="0 -960 960 960" width="34px" fill="#404040"><path d="M144-264v-72h672v72H144Zm0-180v-72h672v72H144Zm0-180v-72h672v72H144Z"/></svg><a href="#"></a></li>
    </ul>
</div>
<?php
$sidebarMenu = ob_get_clean();


ob_start();
?>

<div  id="tagsBar" class="sidebarSlideout" style="left: -100vw; display: <?php echo $tagsVisibility; ?>;">

</div>  
<div  id="sideBar" class="sidebarContainer" onclick="closecategory()" ></div>
<script>
function showcategory() {
    const openbutton = document.querySelector('.menubutton');
    const closebutton = document.querySelector('.backbutton');
    const background = document.querySelector('.sidebarContainer');

    closebutton.style.display = 'flex';
    openbutton.style.display = 'none';
    background.style.display = 'flex';

    const sidebar = document.querySelector('.tagsSidebar');
    sidebar.style.left = '0'; // Move sidebar to the left (open position)
}

function closecategory() {
    const openbutton = document.querySelector('.menubutton');
    const closebutton = document.querySelector('.backbutton');
    const background = document.querySelector('.sidebarContainer');

    closebutton.style.display = 'none';
    openbutton.style.display = 'flex';  
    background.style.display = 'none';
    
    const sidebar = document.querySelector('.tagsSidebar');
    sidebar.style.left = '-100vw'; // Move sidebar to the left beyond viewport (closed position)
}
window.addEventListener('DOMContentLoaded', function() {
    const sidebarContainer = document.querySelector('.sidebarContainer');
    const openbutton = document.querySelector('.menubutton');
    const closebutton = document.querySelector('.backbutton');
    const background = document.querySelector('.sidebarContainer');

    function toggleSidebar() {
        const viewportWidth = window.innerWidth;
        if (viewportWidth > 976) {
            sidebarContainer.style.display = 'none';

            closebutton.style.display = 'none';
            openbutton.style.display = 'flex';  
            background.style.display = 'none';
            
            const sidebar = document.querySelector('.tagsSidebar');
            sidebar.style.left = '-100vw'; // Move sidebar to the left beyond viewport (closed position)
        }
    }

    // Initial call to toggleSidebar to set the initial state based on viewport width
    toggleSidebar();

    // Listen for window resize events and re-evaluate the sidebar visibility
    window.addEventListener('resize', toggleSidebar);
});
</script>

<?php
$sidebarSlideout = ob_get_clean();




if ($showSidebar) {
    $sidebarVisibility = "flex";
} else {
    $sidebarVisibility = "none";
    $sidebarMenu = "";
    $sidebarSlideout = "";
}

if ($showNavBar) {
    $navBarVisibility = "flex";
} else {
    $navBarVisibility = "none";
}

if ($showFooter) {
    $footerVisibility = "flex";
} else {
    $footerVisibility = "none";
}

// display login button
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $loginButtonVisibility = "none";
} else {
    $loginButtonVisibility = "flex";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Meta tags-->   
    <title><?php echo $pageTitle?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="..\assets\images\Toast Logo Simplified.png" type="image/gif" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <!--css link-->
    <link rel="stylesheet" href="../css/default.css">
    <?php echo $pageCSS; ?>
</head>





<body>
<div id="searchModule"></div>
<script>
    function openSearch() {
        const searchBoxHtml = `
        <div class="searchBoxControlled">
            <div class="searchBoxNav">
                <ul>
                    <li><a href="#" onclick="closeSearch()"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#404040"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg><h3>close search</h3></a></li>
                </ul>
            </div>
            <div class="searchBoxContainer">
                <form id="searchForm" action="../php/search.php" method="GET">
                    <input id="bigSearchInputBox" type="text" name="searchInput" placeholder="search...">
                </form>
            </div>
            <div class="searchBoxSaperator">
                <h3>Results</h3>
                <hr width="100%" color="#404040" size="1px" border-radius="5px" />
            </div>
            <div class="searchResult">
                <!--results goes here, it will display dynamically -->
            </div>
        </div>    
        <div class="searchContainer" onclick="closeSearch()"></div> 
        `;
        
        // Select the search background container and insert the search box HTML after it
        const searchBackground = document.querySelector('#searchModule');
        searchBackground.insertAdjacentHTML('afterend', searchBoxHtml);

        // Select elements after they have been inserted into the DOM
        const resultsContainer = document.querySelector('.searchResult');
        const searchModule = document.querySelector('.searchBoxControlled');

        // Show the search box and background
        searchModule.style.display = 'flex';
        searchBackground.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';

        // Focus on the search input field
        const inputBox = document.getElementById('bigSearchInputBox');
        inputBox.focus();

        // Add event listeners for input and keydown events
        inputBox.addEventListener('input', updateSearchResults);
        inputBox.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                submitSearchForm();
            }
        });
    }

    function fetchResults(searchInput) {
        return new Promise((resolve, reject) => {
            fetch(`../php/search.php?input=${encodeURIComponent(searchInput)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => resolve(data))
                .catch(error => reject(error));
        });
    }

    function updateSearchResults() {
        const inputBox = document.getElementById('bigSearchInputBox');
        const resultsContainer = document.querySelector('.searchResult');
        const query = inputBox.value.trim();
        if (query === '') {
            resultsContainer.innerHTML = '';
            return;
        }
        fetchResults(query)
            .then(response => {
                resultsContainer.innerHTML = response;
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
            });
    }

    function submitSearchForm() {
        const inputBox = document.getElementById('bigSearchInputBox');
        const query = inputBox.value.trim();
        if (query === '') {
            const resultsContainer = document.querySelector('.searchResult');
            resultsContainer.innerHTML = '';
            return;
        }

        const form = document.createElement('form');
        form.action = '../page/result.php?searchInput=' + query;

        const input = document.createElement('input');
        input.name = 'searchQuery';
        input.value = query;

        form.appendChild(input);

        document.body.appendChild(form);
        form.submit();
    }

    function closeSearch() {
        const searchModule = document.querySelector('.searchBoxControlled');
        const searchBackground = document.querySelector('.searchContainer');
        if (searchModule) {
            searchModule.remove();
            searchBackground.remove();
        }
        searchBackground.style.display = 'none';
        document.body.style.overflow = '';
        document.documentElement.style.overflow = '';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === '/' && document.activeElement !== document.getElementById('bigSearchInputBox')) {
            event.preventDefault();
            openSearch();
        }
        else if (event.key === 'Escape') {
            closeSearch();
        }
    });
</script>

<?php echo $sidebarSlideout; ?>



<div style="display: <?php echo $navBarVisibility; ?>" class="nav" id="navbar">
    <div class="headerleft">
        <div class="actionButtonContainer">
            <?php echo $sidebarSlideout; ?>
        </div>    
        <div class="logobutton">
            <ul>
                <li><a href="../index.php?redirect=home&currentPage='<?php echo $currentPage; ?>"><img class="logo" src="..\assets\images\logo.png" alt="logo"></a></li>
            </ul>
        </div>
    </div>
    <div class="redirectText">
            <ul>
                <li><a href="../index.php?redirect=home&currentPage='<?php echo $currentPage; ?>'">Home</a></li>
                <li><a href="../index.php?redirect=store&currentPage='<?php echo $currentPage; ?>'">Store</a></li>
                <li><a href="../index.php?redirect=aboutUs&currentPage='<?php echo $currentPage; ?>'">About Us</a></li>
            </ul>
    </div>
    <div class="headerright">
        <div class="cartButton">
            <ul>
                <li><a href="../index.php?redirect=cart&currentPage='<?php echo $currentPage; ?>'"><svg xmlns="http://www.w3.org/2000/svg" height="34" viewBox="0 -960 960 960" width="34" fill="#404040"><path d="M267.79-106q-28.55 0-48.67-20.33T199-175.21q0-28.55 20.33-48.67T268.21-244q28.55 0 48.67 20.33T337-174.79q0 28.55-20.33 48.67T267.79-106Zm423 0q-28.55 0-48.67-20.33T622-175.21q0-28.55 20.33-48.67T691.21-244q28.55 0 48.67 20.33T760-174.79q0 28.55-20.33 48.67T690.79-106ZM255-695l83 192h296l82-192H255Zm-28.88-67H782.5q14 0 20 10.34t1 21.66L696.13-479.14q-7.63 19.64-24.88 31.39T633-436H319l-43 74h484v67H280.19q-41.86 0-61.77-34.4-19.92-34.41.58-68.6l52-88.78L142.12-789H58v-67h128l40.12 94ZM338-503h296-296Z"/></svg></a></li>
            </ul>
        </div>
        <div class="accountbutton">
            <ul>
                <li><a href="../index.php?redirect=profile&currentPage=<?php echo $currentPage; ?>"><svg xmlns="http://www.w3.org/2000/svg" height="34" viewBox="0 -960 960 960" width="34" fill="#404040"><path d="M237-285q54-38 115.5-56.5T480-360q66 0 127.5 18.5T723-285q35-41 52-91t17-104q0-129.67-91.23-220.84-91.23-91.16-221-91.16Q350-792 259-700.84 168-609.67 168-480q0 54 17 104t52 91Zm243-123q-60 0-102-42t-42-102q0-60 42-102t102-42q60 0 102 42t42 102q0 60-42 102t-102 42Zm.28 312Q401-96 331-126t-122.5-82.5Q156-261 126-330.96t-30-149.5Q96-560 126-629.5q30-69.5 82.5-122T330.96-834q69.96-30 149.5-30t149.04 30q69.5 30 122 82.5T834-629.28q30 69.73 30 149Q864-401 834-331t-82.5 122.5Q699-156 629.28-126q-69.73 30-149 30Zm-.28-72q52 0 100-16.5t90-48.5q-43-27-91-41t-99-14q-51 0-99.5 13.5T290-233q42 32 90 48.5T480-168Zm0-312q30 0 51-21t21-51q0-30-21-51t-51-21q-30 0-51 21t-21 51q0 30 21 51t51 21Zm0-72Zm0 319Z"/></svg></a></li>
            </ul>
        </div>
        <div class="loginButton" style="display: <?php echo $loginButtonVisibility?>">
            <ul>
                <li><a href="../index.php?redirect=auth&currentPage=<?php echo $currentPage; ?>"><h3>Login</h3></a></li>
            </ul>
        </div>
    </div>
</div>








<div class="contents">

    <?php echo $pageContents;?>
    
    <style>
        .leftColumn, .rightColumn, .tagsSidebar, .menubutton {
            display: <?php echo $sidebarVisibility; ?>;
        } 

        .contents {
            flex-direction: <?php echo $contentFlexDirection; ?>;
        }
        
        @media (max-width: 975px) {
            .menubutton {
                display: <?php echo $sidebarVisibility; ?>;
                align-items: center;
            }
            
            .actionButtonContainer {
                display: flex;
                align-items: center;
            }

            .leftColumn {
                display: none;
            }
            .rightColumn {
                width: 100%; /* Ensure right column takes the full width */
                padding: 10px 20px; /* Adjust padding as needed */
            }
        }
    </style>
</div>






<div class="footer" style="display: <?php echo $footerVisibility; ?>;">
    <div id="footerResponsive" class="footerContent">
        <div class="footerLogo">
            <img src="../assets/images/Toast Logo.png" class=footerImage></img>
        </div>
        <div class="footerText">
            <h1>Links</h1>
            <div class="footerLinks">
                <a href="https://github.com/PaimanUwU/InkTreeCo.git" target="_blank">GitHub</a>
            </div>
        </div>
    </div>
    <hr height="0.5px" width="100%" color="#404040" size="0.5px" border-radius="5px" border-width="1px" />
    <div id="footerResponsive" class="footerBottom">
        <h3>We sell, we plant trees!</h3>
        <p>© 2024 InkTreeCo. All rights reserved.</p>
    </div>
</div>







<script>
    document.addEventListener('DOMContentLoaded', function() {
        var navbar = document.getElementById('navbar');
        var sidebar = document.getElementById('sidebar');
        window.addEventListener('scroll', function() {
            console.log('scroll event fired'); // Check if this logs
            if (window.scrollY > 0) {
                navbar.classList.add('scrolled');
                //sidebar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
                //sidebar.classList.remove('scrolled');
            }
        });
    });

</script>
<?php echo $pageScript; ?>




</body>
</html>