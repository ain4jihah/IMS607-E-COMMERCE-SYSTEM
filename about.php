<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $about_title = $row['about_title'];
    $about_banner = $row['about_banner'];
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $about_banner; ?>);">
    <div class="inner">
        <h1><?php echo $about_title; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <p>
                    Welcome to Swift Buy, your ultimate destination for fashion-forward clothing and accessories! At Swift Buy, we believe that style is an expression of individuality, and we are here to help you express yourself effortlessly and confidently.
                </p>

                <h2>Our Story</h2>
                <p>
                    Founded with a passion for fashion and a commitment to quality, Swift Buy was born out of the desire to make high-quality, stylish clothing accessible to everyone. We started as a small boutique with a big dream: to revolutionize the way people shop for fashion online. Today, we are proud to serve fashion enthusiasts from all over the world, offering a diverse range of trendy and timeless pieces that cater to every style and occasion.
                </p>

                <h2>Our Mission</h2>
                <p>
                    Our mission is simple: to provide our customers with the latest fashion trends at unbeatable prices. We are dedicated to curating a wide selection of apparel and accessories that reflect the latest styles and cater to every taste. From casual wear to chic evening outfits, our collections are designed to help you look and feel your best.
                </p>

                <h2>What We Offer</h2>
                <p>
                    At Swift Buy, we offer a comprehensive range of clothing and accessories for men, women, and children. Our collections include:
                </p>
                <ul>
                    <li><strong>Trendy Apparel:</strong> Stay ahead of the fashion curve with our latest arrivals.</li>
                    <li><strong>Timeless Classics:</strong> Invest in pieces that never go out of style.</li>
                    <li><strong>Accessories:</strong> Complete your look with our selection of bags, shoes, jewelry, and more.</li>
                    <li><strong>Seasonal Collections:</strong> Discover our specially curated collections for every season and occasion.</li>
                </ul>

                <h2>Quality and Sustainability</h2>
                <p>
                    We are committed to quality and sustainability. Our products are carefully selected to ensure they meet our high standards for craftsmanship and durability. We also strive to incorporate sustainable practices into our operations, from sourcing eco-friendly materials to reducing waste in our supply chain.
                </p>

                <h2>Customer Satisfaction</h2>
                <p>
                    At Swift Buy, our customers are at the heart of everything we do. We are dedicated to providing exceptional customer service and a seamless shopping experience. Our team is always here to assist you with any questions or concerns, ensuring that your shopping experience with us is nothing short of perfect.
                </p>

                <h2>Join the Swift Buy Community</h2>
                <p>
                    Join our fashion-forward community and stay updated on the latest trends, exclusive offers, and new arrivals. Follow us on social media, subscribe to our newsletter, and be part of a vibrant community of fashion enthusiasts who share your passion for style.
                </p>

                <p>
                    Thank you for choosing Swift Buy. We look forward to helping you express your unique style!
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
