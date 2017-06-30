<?php
/**
 * TAG ALL THE THINGS
 *
 * This script generates a list of tags and details associated with those tags
 */

use UNL\Tags\Tag;

require __DIR__ . '/../vendor/autoload.php';

$tags = [];

//root tag
$tags['unl'] = new Tag('unl', 'University of Nebraska–Lincoln');

/**
 * Audiences, can tag content that pertains to these audiences
 */
$tags['audiences'] = new Tag('audiences', 'Audiences');
$tags['unl']->addChild($tags['audiences']);

$audiences = [
    'students' => 'Students',
    'faculty' => 'Faculty',
    'staff' => 'Staff',
    'perspective_student' => 'Perspective Student',
    'parents' => 'Parents',
    'emeriti' => 'Emeriti',
    'visitors' => 'Visitors',
    'undergraduate_students' => 'Undergraduate Students',
    'graduate_students' => 'Graduate Students',
    'transfer_students' => 'Transfer Students',
    'alumni' => 'Alumni'
];

foreach ($audiences as $machineName => $humanName) {
    $machineName = 'audiences__'.$machineName;
    $tags[$machineName] = new Tag($machineName, $humanName);
    $tags['audiences']->addChild($tags[$machineName]);
}

$tags['campuses'] = new Tag('campuses', 'Campuses');
$campuses = [
    'city' => [
        'humanName' => 'City',
    ],
    'east' => [
        'humanName' => 'East',
    ],
    'innovation' => [
        'humanName' => 'Innovation',
    ],
];

foreach ($campuses as $machineName => $details) {
    $machineName = 'campuses__'.$machineName;
    $tags[$machineName] = new Tag($machineName, 'Campus: '.$details['humanName']);
    $tags['campuses']->addChild($tags[$machineName]);
}

/**
 * General
 * 
 * General tags that don't exactly fit anywhere else
 */
$general = [
    'sports' => 'Sports',
    'jobs' => 'Jobs',
    'research' => 'Research',
    'internships' => 'Internships',
    'club' => 'Club',
    'event' => 'Event',
    'campus_life' => 'Campus Life'
];

foreach ($general as $machineName => $humanName) {
    $tags[$machineName] = new Tag($machineName, $humanName);
    $tags['unl']->addChild($tags[$machineName]);
}

/**
 * Add tags for each college
 * Retrieved from https://catalog.unl.edu/undergraduate/
 */
$tags['colleges'] = new Tag('colleges', 'Colleges');
$tags['unl']->addChild($tags['colleges']);

$colleges = [
    'casnr' => 'Agricultural Sciences & Natural Resources',
    'architecture' => 'Architecture',
    'arts_sciences' => 'Arts & Sciences',
    'cob' => 'College of Business',
    'education_human_sciences' => 'Education & Human Sciences',
    'engineering' => 'Engineering',
    'fine_arts' => 'Fine & Performing Arts',
    'journalism' => 'Journalism & Mass Communications',
    'public_affairs_community_service' => 'Public Affairs & Community Service',
    'exploratory' => 'Exploratory & Pre-Professional Advising Center',
];

foreach ($colleges as $machineName => $humanName) {
    $machineName = 'colleges__'.$machineName;
    $tags[$machineName] = new Tag($machineName, 'College: '.$humanName);
    $tags['colleges']->addChild($tags[$machineName]);
}

/**
 * TODO: Replace these manual AOS tags with an api out of course leaf
 */
/**
 * Add tags for each business area of study
 * Retrieved from https://catalog.unl.edu/undergraduate/
 */
$tags['aos'] = new Tag('aos', 'Areas of Study');
$tags['unl']->addChild($tags['aos']);

$business_areas = [
    'accounting' => 'Accounting',
    'actuarial_sciences' => 'Actuarial Science (Business)',
    'agribusiness' => 'Agribusiness (Business)',
    'administration' => 'Administration',
    'analytics' => 'Business Analytics',
    'economics' => 'Economics (Business)',
    'finance' => 'Finance',
    'global_leadership' => 'Global Leadership',
    'international_business' => 'International Business',
    'management' => 'Management',
    'marketing' => 'Marketing',
    'supply_chain_management' => 'Supply Chain Management'
];

foreach ($business_areas as $machineName=>$humanName) {
    $machineName = 'aos__cob__'.$machineName;
    $tags[$machineName] = new Tag($machineName, 'Area of Study: '.$humanName);
    $tags['colleges__cob']->addChild($tags[$machineName]);
    $tags['aos']->addChild($tags[$machineName]);
}

$casnr_areas = [
    'agribusiness' => 'Agribusiness (CASNR)',
    'ag_environmental_sciences_communication' => 'Agricultural & Environmental Sciences Communication',
    'ag_economics' => 'Agricultural Economics',
    'ag_eduction' => 'Agricultural Education',
    'agronomy' => 'Agronomy',
    'animal_science' => 'Animal Science',
    'applied_climate_science' => 'Applied Climate Science',
    'applied_science' => 'Applied Science',
    'biochemistry' => 'Biochemistry (CASNR)',
    'comp_bio_informatics' => 'Computational Biology & Bioinformatics Minor (CASNR)',
    'energy_science' => 'Energy Science',
    'engler_agribusiness_entrepreneurship' => 'Engler Agribusiness Entrepreneurship',
    'environmental_restoration_science' => 'Environmental Restoration Science',
    'environmental_studies' => 'Environmental Studies (CASNR)',
    'fisheries_wildlife' => 'Fisheries & Wildlife',
    'food_science_tech' => 'Food Science & Technology',
    'food_tech_for_companion_animals' => 'Food Technology for Companion Animals',
    'food_energy_water_in_society' => 'Food, Energy, and Water in Society',
    'forensic_science' => 'Forensic Science',
    'general' => 'General (CASNR)',
    'grassland_ecology_management' => 'Grassland Ecology & Management',
    'grazing_livestock_systems' => 'Grazing Livestock Systems',
    'Horticulture' => 'Horticulture',
    'hospitality_restaurant_tourism_management' => 'Hospitality, Restaurant & Tourism Management (CASNR)',
    'insect_science' => 'Insect Science',
    'integrated_science' => 'Integrated Science',
    'international_agriculture_natural_resources' => 'International Agriculture & Natural Resources',
    'mechanized_systems_management' => 'Mechanized Systems Management',
    'microbiology' => 'Microbiology (CASNR)',
    'natural_resource_environmental_economics' => 'Natural Resource & Environmental Economics',
    'pga_golf_management' => 'PGA Golf Management',
    'plant_biology' => 'Plant Biology (CASNR)',
    'pre-veterinary_medicine' => 'Pre-Veterinary Medicine',
    'statistics' => 'Statistics (CASNR)',
    'turfgrass_landscape_management' => 'Turfgrass & Landscape Management',
    'veterinary_science' => 'Veterinary Science',
    'veterinary_tech' => 'Veterinary Technology',
    'water_science' => 'Water Science',
];

foreach ($business_areas as $machineName=>$humanName) {
    $machineName = 'aos__casnr__'.$machineName;
    $tags[$machineName] = new Tag($machineName, 'Area of Study: '.$humanName);
    $tags['colleges__casnr']->addChild($tags[$machineName]);
    $tags['aos']->addChild($tags[$machineName]);
}


$buildings = json_decode(file_get_contents('http://maps.unl.edu/?view=allbuildings&format=json'), true);
$tags['buildings'] = new Tag('buildings', 'Buildings');
$tags['unl']->addChild($tags['buildings']);
foreach ($buildings as $machineName=>$humanName) {
    $machineName = 'buildings__'.$machineName;
    $tags[$machineName] = new Tag($machineName, 'Building: '.$humanName);
    $tags['buildings']->addChild($tags[$machineName]);
}

//Now get all of the org units
//TODO: what about org units that are also colleges or listed elsewhere in this? Mark them as an alias somehow?
$org_units = json_decode(file_get_contents('https://directory.unl.edu/departments/1?format=json'), true);
$tags['org_units'] = new Tag('org_units', 'Org Units');
$tags['unl']->addChild($tags['org_units']);

function addOrgUnit($details, &$tags, Tag $parent = null)
{
    $machineName = 'org_units__'.$details['org_unit'];
    $tags[$machineName] = new Tag($machineName, 'Org Unit: '.$details['name']);
    $tags['org_units']->addChild($tags[$machineName]);
    
    if ($parent) {
        $parent->addChild($tags[$machineName]);
    }
    
    if (isset($details['children'])) {
        //Add all children
        foreach ($details['children'] as $child) {
            addOrgUnit($child, $tags, $tags[$machineName]);
        }
    }
}

//Now add them
addOrgUnit($org_units, $tags);


//Now export
$unl_tree = json_encode($tags['unl'], JSON_PRETTY_PRINT);
file_put_contents(__DIR__ . '/../data/unl_tree.json', $unl_tree);

$flat = [];
foreach($tags as $tag) {
    $flat[$tag->getMachineName()] = $tag->getHumanName();
}

file_put_contents(__DIR__ . '/../data/flat.json', json_encode($flat, JSON_PRETTY_PRINT));
