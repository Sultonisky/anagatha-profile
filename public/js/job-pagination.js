/**
 * Job Listing Pagination
 * Handles pagination for job cards (3 columns x 6 rows = 18 cards per page)
 */

(function() {
    'use strict';

    const CARDS_PER_PAGE = 18; // 3 columns x 6 rows
    const CARDS_PER_ROW = 3;

    let currentPage = 1;
    let totalPages = 1;
    let jobCards = [];
    let visibleJobCards = []; // Store filtered cards separately
    let paginationContainer = null;
    let paginationPages = null;
    let prevButton = null;
    let nextButton = null;

    /**
     * Get all job cards from DOM
     */
    function getAllJobCards() {
        const grid = document.getElementById('jobCardsGrid');
        if (!grid) return [];
        return Array.from(grid.querySelectorAll('.job-card'));
    }

    /**
     * Get visible job cards only (cards that match current filters)
     * This should be called after filtering is done
     */
    function getVisibleJobCards() {
        return visibleJobCards.filter(card => {
            // Check if card is still in DOM and matches current filter state
            return card.parentNode && card.style.display !== 'none';
        });
    }

    /**
     * Initialize pagination
     */
    function init() {
        const grid = document.getElementById('jobCardsGrid');
        if (!grid) return;

        jobCards = Array.from(grid.querySelectorAll('.job-card'));
        if (jobCards.length === 0) return;

        // Initialize visibleJobCards with all cards (no filter applied yet)
        visibleJobCards = jobCards.filter(card => {
            // Only include cards that are currently visible (not hidden by CSS or other means)
            return card.style.display !== 'none';
        });
        
        // If no visible cards found, use all cards
        if (visibleJobCards.length === 0) {
            visibleJobCards = jobCards;
        }
        
        totalPages = Math.ceil(visibleJobCards.length / CARDS_PER_PAGE);

        // Only show pagination if there's more than one page
        if (totalPages <= 1) {
            // If only 1 page, show all cards
            if (visibleJobCards.length > 0) {
                visibleJobCards.forEach(card => {
                    if (card.parentNode) {
                        card.style.display = 'grid';
                    }
                });
            }
            return;
        }

        paginationContainer = document.getElementById('jobPagination');
        paginationPages = document.getElementById('paginationPages');
        prevButton = document.getElementById('paginationPrev');
        nextButton = document.getElementById('paginationNext');

        if (!paginationContainer || !paginationPages || !prevButton || !nextButton) {
            return;
        }

        // Show pagination
        paginationContainer.style.display = 'flex';

        // Get current page from URL or default to 1
        const urlParams = new URLSearchParams(window.location.search);
        const pageParam = parseInt(urlParams.get('page'), 10);
        if (pageParam && pageParam > 0 && pageParam <= totalPages) {
            currentPage = pageParam;
        }

        // Initialize
        renderPagination();
        showPage(currentPage);

        // Event listeners
        prevButton.addEventListener('click', goToPreviousPage);
        nextButton.addEventListener('click', goToNextPage);
    }

    /**
     * Show specific page
     */
    function showPage(page) {
        if (page < 1 || page > totalPages) return;

        currentPage = page;
        
        // Use stored visibleJobCards array (cards that match filters)
        // If empty, try to get from DOM (fallback)
        let visibleCards = visibleJobCards;
        if (visibleCards.length === 0) {
            visibleCards = Array.from(document.querySelectorAll('#jobCardsGrid .job-card')).filter(card => {
                return card.style.display !== 'none';
            });
            // Update stored array
            visibleJobCards = visibleCards;
        }
        
        // Filter out cards that are no longer in DOM
        visibleCards = visibleCards.filter(card => card.parentNode !== null);
        
        const startIndex = (page - 1) * CARDS_PER_PAGE;
        const endIndex = startIndex + CARDS_PER_PAGE;

        // First, hide all cards in the visibleJobCards array (that match filters)
        visibleCards.forEach(card => {
            if (card.parentNode) { // Make sure card is still in DOM
                card.style.display = 'none';
            }
        });

        // Then show only the cards for current page
        visibleCards.forEach((card, index) => {
            if (card.parentNode && index >= startIndex && index < endIndex) {
                card.style.display = 'grid';
            }
        });
        
        // Update stored array in case it was filtered
        visibleJobCards = visibleCards;

        // Update pagination UI
        renderPagination();
        updateButtons();

        // Scroll to top of job listings section
        const jobListingsSection = document.querySelector('.job-listings-section');
        if (jobListingsSection) {
            const offsetTop = jobListingsSection.offsetTop - 100;
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }

        // Update URL without reload
        const url = new URL(window.location);
        if (page === 1) {
            url.searchParams.delete('page');
        } else {
            url.searchParams.set('page', page);
        }
        window.history.pushState({ page }, '', url);
    }

    /**
     * Render pagination numbers
     */
    function renderPagination() {
        if (!paginationPages) return;

        paginationPages.innerHTML = '';

        const maxVisiblePages = 7;
        let startPage = 1;
        let endPage = totalPages;

        if (totalPages > maxVisiblePages) {
            if (currentPage <= 4) {
                // Show first pages
                endPage = maxVisiblePages - 2;
            } else if (currentPage >= totalPages - 3) {
                // Show last pages
                startPage = totalPages - (maxVisiblePages - 3);
            } else {
                // Show pages around current
                startPage = currentPage - 2;
                endPage = currentPage + 2;
            }
        }

        // First page
        if (startPage > 1) {
            createPageButton(1);
            if (startPage > 2) {
                createEllipsis();
            }
        }

        // Page numbers
        for (let i = startPage; i <= endPage; i++) {
            createPageButton(i);
        }

        // Last page
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                createEllipsis();
            }
            createPageButton(totalPages);
        }
    }

    /**
     * Create page button
     */
    function createPageButton(pageNum) {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'job-pagination__page';
        button.textContent = pageNum;
        button.setAttribute('aria-label', `Go to page ${pageNum}`);

        if (pageNum === currentPage) {
            button.classList.add('is-active');
        }

        button.addEventListener('click', () => showPage(pageNum));
        paginationPages.appendChild(button);
    }

    /**
     * Create ellipsis
     */
    function createEllipsis() {
        const ellipsis = document.createElement('span');
        ellipsis.className = 'job-pagination__ellipsis';
        ellipsis.textContent = '...';
        ellipsis.setAttribute('aria-hidden', 'true');
        paginationPages.appendChild(ellipsis);
    }

    /**
     * Update prev/next buttons state
     */
    function updateButtons() {
        if (!prevButton || !nextButton) return;

        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages;

        if (prevButton.disabled) {
            prevButton.classList.add('is-disabled');
        } else {
            prevButton.classList.remove('is-disabled');
        }

        if (nextButton.disabled) {
            nextButton.classList.add('is-disabled');
        } else {
            nextButton.classList.remove('is-disabled');
        }
    }

    /**
     * Go to previous page
     */
    function goToPreviousPage() {
        if (currentPage > 1) {
            showPage(currentPage - 1);
        }
    }

    /**
     * Go to next page
     */
    function goToNextPage() {
        if (currentPage < totalPages) {
            showPage(currentPage + 1);
        }
    }

    /**
     * Update pagination when filters change
     */
    function update(visibleCount, filteredCards) {
        const grid = document.getElementById('jobCardsGrid');
        if (!grid) return;

        jobCards = Array.from(grid.querySelectorAll('.job-card'));
        
        // Store the filtered cards array - this is the source of truth for pagination
        if (filteredCards && Array.isArray(filteredCards) && filteredCards.length > 0) {
            // Use the provided filtered cards array
            visibleJobCards = filteredCards.filter(card => card.parentNode !== null);
        } else {
            // Fallback: get visible cards from DOM
            visibleJobCards = Array.from(grid.querySelectorAll('.job-card')).filter(card => {
                return card.parentNode && card.style.display !== 'none';
            });
        }
        
        // Recalculate total pages based on actual visible cards count
        const actualVisibleCount = visibleJobCards.length;
        totalPages = Math.ceil(actualVisibleCount / CARDS_PER_PAGE);

        // Reset to page 1 if current page is out of bounds
        if (currentPage > totalPages && totalPages > 0) {
            currentPage = 1;
        }

        // Re-render pagination
        if (totalPages <= 1) {
            if (paginationContainer) {
                paginationContainer.style.display = 'none';
            }
            // If only 1 page or less, show all visible cards
            if (visibleJobCards.length > 0) {
                visibleJobCards.forEach(card => {
                    if (card.parentNode) {
                        card.style.display = 'grid';
                    }
                });
            }
        } else {
            if (paginationContainer) {
                paginationContainer.style.display = 'flex';
            }
            renderPagination();
            updateButtons();
            // Show current page (will handle hiding/showing cards correctly)
            showPage(currentPage);
        }
    }

    // Expose update function
    window.jobPagination = {
        update: update,
        showPage: showPage,
        getCurrentPage: () => currentPage,
        getTotalPages: () => totalPages
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Listen for filter updates
    window.addEventListener('jobFilterUpdated', function(event) {
        if (event.detail) {
            const visibleCount = event.detail.visibleCount !== undefined ? event.detail.visibleCount : 0;
            const filteredCards = event.detail.filteredCards;
            update(visibleCount, filteredCards);
        } else {
            // Recalculate visible count
            const grid = document.getElementById('jobCardsGrid');
            if (grid) {
                const visibleCards = Array.from(grid.querySelectorAll('.job-card')).filter(card => {
                    return card.style.display !== 'none';
                });
                update(visibleCards.length, visibleCards);
            }
        }
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(event) {
        const urlParams = new URLSearchParams(window.location.search);
        const pageParam = parseInt(urlParams.get('page'), 10);
        const page = (pageParam && pageParam > 0 && pageParam <= totalPages) ? pageParam : 1;
        if (page !== currentPage) {
            showPage(page);
        }
    });

})();

