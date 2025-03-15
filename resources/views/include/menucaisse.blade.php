<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        
        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation"></div>
                <h5>Catégories de Produits</h5>
                <ul id="categories-menu" class="list-group">
                    <!-- Les catégories seront injectées ici -->
                </ul>
    </div>
</nav>

<script>
    // Fonction pour récupérer les catégories depuis l'API
    async function fetchCategories() {
        try {
            const response = await fetch('http://127.0.0.1:8000/api/admin/categories/grouped'); // Remplace l'URL par l'URL correcte de ton API
            if (!response.ok) throw new Error('Erreur lors du chargement des catégories');
            
            const categories = await response.json(); // Stocke les catégories
            console.log('Catégories:', categories);

            // Appel à la fonction pour générer les éléments du menu
            generateCategoryMenu(categories);
        } catch (error) {
            console.error('Erreur:', error);
        }
    }

    // Fonction pour générer les éléments du menu à partir des catégories récupérées
    function generateCategoryMenu(categories) {
        const menuContainer = document.getElementById('categories-menu');
        menuContainer.innerHTML = ''; // Vider le menu actuel avant d'ajouter les nouvelles catégories

        categories.forEach(category => {
            const menuItem = document.createElement('li');
            menuItem.classList.add('list-group-item');
            menuItem.textContent = category.category_name; // Assure-toi que chaque catégorie a une propriété 'name'
            
            // Associer un événement click pour charger les produits de la catégorie
            menuItem.onclick = () => loadProducts(category.category_name); // Passe le nom de la catégorie dans la fonction loadProducts
            menuContainer.appendChild(menuItem); // Ajouter l'élément au menu
        });
    }

    // Fonction pour charger les produits en fonction de la catégorie
    function loadProducts(categoryName) {
        console.log(`Charger les produits de la catégorie: ${categoryName}`);
        // Ici tu pourrais appeler une autre API pour charger les produits spécifiques à la catégorie
    }

    // Charger les catégories au démarrage de la page
    document.addEventListener('DOMContentLoaded', fetchCategories);
</script>