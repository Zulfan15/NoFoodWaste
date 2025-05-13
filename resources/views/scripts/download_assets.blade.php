@php
// Marker icon
$foodMarkerUrl = "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png";
$foodMarkerPath = public_path('assets/images/food-marker.png');
file_put_contents($foodMarkerPath, file_get_contents($foodMarkerUrl));

// Sample food images
$foodUrls = [
    "https://images.unsplash.com/photo-1564671165093-20688ff1fffa?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" => "food1.jpg",
    "https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" => "food2.jpg",
    "https://images.unsplash.com/photo-1518843875459-f738682238a6?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" => "food3.jpg",
];

foreach ($foodUrls as $url => $filename) {
    $path = public_path('assets/images/' . $filename);
    file_put_contents($path, file_get_contents($url));
}

// User avatars
$avatarUrls = [
    "https://randomuser.me/api/portraits/men/41.jpg" => "user1.jpg",
    "https://randomuser.me/api/portraits/women/32.jpg" => "user2.jpg",
    "https://randomuser.me/api/portraits/men/23.jpg" => "user3.jpg",
];

foreach ($avatarUrls as $url => $filename) {
    $path = public_path('assets/images/user/' . $filename);
    if (!file_exists(dirname($path))) {
        mkdir(dirname($path), 0755, true);
    }
    file_put_contents($path, file_get_contents($url));
}

// Default avatar
$defaultAvatarUrl = "https://randomuser.me/api/portraits/lego/1.jpg";
$defaultAvatarPath = public_path('assets/images/user/avatar.jpg');
if (!file_exists(dirname($defaultAvatarPath))) {
    mkdir(dirname($defaultAvatarPath), 0755, true);
}
file_put_contents($defaultAvatarPath, file_get_contents($defaultAvatarUrl));

// Testimonial images
$testimonialUrls = [
    "https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" => "testimonial1.jpg",
    "https://images.unsplash.com/photo-1593113598332-cd288d649433?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" => "testimonial2.jpg",
    "https://images.unsplash.com/photo-1506368249639-73a05d6f6488?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" => "testimonial3.jpg",
];

foreach ($testimonialUrls as $url => $filename) {
    $path = public_path('assets/images/' . $filename);
    file_put_contents($path, file_get_contents($url));
}

echo 'Assets downloaded successfully!';
@endphp
