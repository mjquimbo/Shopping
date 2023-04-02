<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $index = 0;
        $pictures = $this->pictures();
        $products = $this->populateProducts();
        return [
            'brand' => $products[$index]['brand'],
            'description' => $products[$index]['description'],
            'image' => $pictures[$index++],
            'model' => fake()->text(10),
            //'image' => 'https://placedog.net/200/200/id=' . rand(1, 1000),
            'price' => fake()->randomFloat('2', 1, 1000)
        ];
    
    // return $products[$index++];
    }

    public function populateProducts()
    {

        $products = [
            [
                'brand' => 'Powdery Matte',
                'description' => 'Discover the ultimate fusion of style and comfort with our powdery matte tints, expertly crafted for a seamless, velvety finish. Elevate your look with our highly pigmented shades that glide on effortlessly, delivering lasting, transfer-proof color that complements your natural beauty. Shop now and indulge in the perfect balance of elegance and wearability, making every day a statement.',
                'image' => 'images/1.jpg',
                'model' => 'model1',
                'price' => fake()->randomFloat('2', 1, 1000)
            ],
            [
                'brand' => 'Liptint',
                'description' => 'Introducing our 2-in-1 lip & cheek tint – the affordable, multitasking beauty essential! Enjoy stunning, long-lasting color for lips and cheeks with our lightweight, blendable formula. Ideal for all skin tones, this pocket-sized wonder simplifies your makeup routine. Simply dab, blend, and build intensity for a natural flush or bold pop of color. Shop now for effortless beauty on a budget.',
                'image' => 'images/2.jpg',
                'model' => 'model2',
                'price' => fake()->randomFloat('2', 1, 1000)
            ],
            [
                'brand' => 'Lip Gloss',
                'description' => 'Discover the ultimate fusion of style and comfort with our powdery matte tints, expertly crafted for a seamless, velvety finish. Elevate your look with our highly pigmented shades that glide on effortlessly, delivering lasting, transfer-proof color that complements your natural beauty. Shop now and indulge in the perfect balance of elegance and wearability, making every day a statement.',
                'image' => 'images/3.jpg',
                'model' => 'model3',
                'price' => fake()->randomFloat('2', 1, 1000)
            ],
            [
                'brand' => 'Cream Blush',
                'description' => 'Elevate your natural glow with our luxurious cream blush collection, designed to create a radiant, dewy finish that lasts all day. Our creamy, blendable formula is infused with nourishing ingredients to provide a silky smooth texture that effortlessly enhances your complexion. Shop now and indulge in the perfect balance of glamour and nourishment, giving you the confidence to embrace your beauty, day or night',
                'image' => 'images/4.jpg',
                'model' => 'model4',
                'price' => fake()->randomFloat('2', 1, 1000)
            ],
            [
                'brand' => 'Liquid Foundation',
                'description' => 'Experience flawless, natural-looking skin with our liquid foundation collection, expertly formulated to provide full coverage that lasts all day. Our lightweight, breathable formula blends seamlessly into the skin, delivering a smooth, matte finish that enhances your natural beauty. Choose from our range of shades to find your perfect match and shop now for a confident, flawless look that empowers you to take on the day.',
                'image' => 'images/5.jpg',
                'model' => 'model5',
                'price' => fake()->randomFloat('2', 1, 1000)
            ],
            [
                'brand' => 'Glow Serum',
                'description' => 'Unlock your skins radiance with our transformative glow serum collection, expertly formulated to nourish and revitalize your complexion. Our lightweight, non-greasy serums are infused with potent antioxidants and natural ingredients that work together to brighten, hydrate, and smooth your skin for a radiant, youthful glow. Shop now and experience the ultimate in luxury skincare, with our glow serums that leave your skin feeling nourished and revitalized.',
                'image' => 'images/6.jpg',
                'model' => 'model6',
                'price' => fake()->randomFloat('2', 1, 1000)
            ],
            [
                'brand' => 'Facial Cream',
                'description' => 'Transform your skin with our nourishing facial cream collection, designed to deliver a luxurious, spa-like experience in the comfort of your own home. Our rich, hydrating formulas are infused with natural ingredients to provide deep, long-lasting moisture that leaves your skin feeling soft, supple, and rejuvenated. Whether you are looking to reduce the appearance of fine lines, even out your complexion, or simply pamper yourself, our facial creams offer the perfect solution. Shop now and treat yourself to radiant, glowing skin that exudes confidence and beauty.',
                'image' => 'images/7.jpg',
                'model' => 'model7',
                'price' => fake()->randomFloat('2', 1, 1000)
            ]
        ];

        return $products;
    }


    public function pictures()
    {
        return [
            'images/1.jpg',
            'images/2.jpg',
            'images/3.jpg',
            'images/4.jpg',
            'images/5.jpg',
            'images/6.jpg',
            'images/7.jpg',
          
        ];
    }
}
