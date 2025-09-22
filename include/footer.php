<footer class="footer">
    <div class="con">
        <p>&copy; <?php echo date("Y"); ?> Toy Store. All Rights Reserved.</p>
        <ul class="social-links">
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">Instagram</a></li>
        </ul>
    </div>
</footer>

<style>
/* Footer Styling */
.footer {
    background: #333;
    color: white;
    text-align: center;
    padding: 15px 0;
    /* position: absolute; */
    width: 99%;
    margin: auto;
    margin-top: 1%;
    
}

.footer .con {
    max-width: 1200px;
    margin: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.footer p {
    margin: 5px 0;
    font-size: 16px;
}

.social-links {
    list-style: none;
    padding: 0;
    margin: 10px 0 0;
    display: flex;
    justify-content: center;
}

.social-links li {
    margin: 0 10px;
}

.social-links a {
    text-decoration: none;
    color: white;
    font-size: 18px;
    transition: color 0.3s ease;
}

.social-links a:hover {
    color: #f1c40f;
}
</style>
