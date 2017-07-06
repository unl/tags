<?php
/**
 * TAG ALL THE THINGS
 *
 * This script generates a list of tags and details associated with those tags
 */

use Symfony\Component\DomCrawler\Crawler;
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
    'parents' => 'Parents',
    'emeriti' => 'Emeriti',
    'visitors' => 'Visitors',
    'alumni' => 'Alumni'
];

foreach ($audiences as $machineName => $humanName) {
    $machineName = 'audiences__'.$machineName;
    $tags[$machineName] = new Tag($machineName, $humanName);
    $tags['audiences']->addChild($tags[$machineName]);
}

$student_audiences = [
    'transfer' => 'Transfer Students',
    'prospective' => 'Prospective Students',
    'graduate' => 'Graduate Students',
    'undergraduate' => 'Undergraduate Students',
    'current' => 'Current Students',
    'international' => 'International Students',
    'freshmen' => 'Freshmen',
    'junior' => 'Junior',
    'sophomore' => 'Sophomore',
    'senior' => 'Senior',
];

foreach ($student_audiences as $machineName => $humanName) {
    $machineName = 'audiences__students__'.$machineName;
    $tags[$machineName] = new Tag($machineName, $humanName);
    $tags['audiences__students']->addChild($tags[$machineName]);
}

/**
 * Funding opportunities
 */
$tags['funding'] = new Tag('funding', 'Funding');
$tags['unl']->addChild($tags['funding']);

$funding = [
    'scholarships' => 'Scholarships',
    'grants' => 'Grants',
];

foreach ($funding as $machineName => $humanName) {
    $machineName = 'funding__'.$machineName;
    $tags[$machineName] = new Tag($machineName, $humanName);
    $tags['funding']->addChild($tags[$machineName]);
}

/**
 * Campuses
 */
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
    'athletics' => 'Athletics',
    'jobs' => 'Jobs',
    'research' => 'Research',
    'internships' => 'Internships',
    'rso' => 'Student Organizations',
    'event' => 'Events',
    'campus_life' => 'Campus Life',
    'diversity' => 'Diversity',
    'centers' => 'Centers',
    'institutes' => 'Institutes',
    'extension' => 'Extension',
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

$tags['majors'] = new Tag('majors', 'Majors');
$tags['unl']->addChild($tags['majors']);

//Public affairs is actually out of Omaha, but classes are taught here
$tags['pacs'] = new Tag('public_affairs_community_service', 'College: Public Affairs & Community Service');
$tags['colleges']->addChild($tags['pacs']);

$majors = getMajorsForCollege('.filter_43');

foreach ($majors as $humanName) {
    $majorMachineName = Tag::sanitizeMachineName($humanName);
    $majorMachineName = 'majors__pacs__'.$majorMachineName;
    $tags[$majorMachineName] = new Tag($majorMachineName, 'Major: '.$humanName);
    $tags['pacs']->addChild($tags[$majorMachineName]);
    $tags['majors']->addChild($tags[$majorMachineName]);
}

/**
 * Areas of Interest is retrieved from the areas of interest listed on
 * https://catalog.unl.edu/undergraduate/majors/
 */
$tags['aoi'] = new Tag('aoi', 'Areas of Interest');
$tags['unl']->addChild($tags['aoi']);

$areas_of_interest = [
    'agriculture_food' => 'Agriculture & Food',
    'animals_plants' => 'Animals & Plants',
    'arts' => 'Arts',
    'business' => 'Business',
    'communicating_writing' => 'Communicating & Writing',
    'computers_technology' => 'Computers & Technology',
    'design_creativity' => 'Design & Creativity',
    'environment_energy_sustainability' => 'Environment, Energy, & Sustainability',
    'ethics_social_justice' => 'Ethics & Social Justice',
    'family_community' => 'Family & Community',
    'global_perspectives_cultures_languages' => 'Global Perspectives, Cultures, & Languages',
    'health_wellness' => 'Health & Wellness',
    'human_behavior' => 'Human Behavior',
    'life_sciences' => 'Life Sciences',
    'making_building' => 'Making & Building',
    'math_analytics_data_science' => 'Math, Analytics, & Data Science',
    'media' => 'Media',
    'physical_science' => 'Physical Science',
    'politics_current_events' => 'Politics & Current Events',
    'teaching' => 'Teaching',
];

foreach ($areas_of_interest as $machineName=>$humanName) {
    $machineName = 'aoi__'.$machineName;
    $tags[$machineName] = new Tag($machineName, 'Area of Interest: '.$humanName);
    $tags['aoi']->addChild($tags[$machineName]);
}

/**
 * Add buildings
 */
$buildings = json_decode(file_get_contents('http://maps.unl.edu/?view=allbuildings&format=json'), true);
$tags['buildings'] = new Tag('buildings', 'Buildings');
$tags['unl']->addChild($tags['buildings']);
foreach ($buildings as $machineName=>$humanName) {
    $machineName = 'buildings__'.$machineName;
    $tags[$machineName] = new Tag($machineName, 'Building: '.$humanName);
    $tags['buildings']->addChild($tags[$machineName]);
}

//Now get all of the org units
$org_units = json_decode(file_get_contents('https://directory.unl.edu/departments/1?format=json'), true);
$tags['org_units'] = new Tag('org_units', 'Org Units');
$tags['unl']->addChild($tags['org_units']);

function addOrgUnit($details, &$tags, Tag $parent = null)
{
    if ($details['suppress']) {
        //Don't add suppressed entries
        return;
    }
    
    $college_org_units = [
        50000787 => '.filter_26', //College of Agricultural Sciences and Natural Resources
        50000800 => '.filter_31', //IANR College of Education & Human Sciences
        50000928 => '', //NE College of Technical Agriculture
        50000896 => '.filter_27', //College of Architecture
        50000906 => '.filter_28', //College of Arts & Sciences
        50000897 => '.filter_29', //College of Business
        50000910 => '.filter_31', //College of Education & Human Sciences
        50000907 => '.filter_32', //College of Engineering
        50000908 => '.filter_38', //College of Journalism & Mass Communications
        50000899 => '', //College of Law
        50000898 => '.filter_34', //Hixson-Lied College of Fine & Performing Arts
    ];
    
    $machineName = 'org_units__'.$details['org_unit'];
    
    if (array_key_exists($details['org_unit'], $college_org_units)) {
        //This is a college
        $tags[$machineName] = new Tag($machineName, 'College: '.$details['name']);
        $tags['colleges']->addChild($tags[$machineName]);
        
        $majors = [];
        if ($details['org_unit'] == 50000928) {
            
        } else if ($details['org_unit'] == 50000899) {
            
        } else {
            $majors = getMajorsForCollege($college_org_units[$details['org_unit']]);
        }

        foreach ($majors as $humanName) {
            $majorMachineName = Tag::sanitizeMachineName($humanName);
            $majorMachineName = 'majors__'.$details['org_unit'].'__'.$majorMachineName;
            $tags[$majorMachineName] = new Tag($majorMachineName, 'Major: '.$humanName);
            $tags[$machineName]->addChild($tags[$majorMachineName]);
            $tags['majors']->addChild($tags[$majorMachineName]);
        }
        
    } else {
        //Just a regular org unit
        $tags[$machineName] = new Tag($machineName, 'Org Unit: '.$details['name']);
    }
    
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

function getMajorsForCollege($selector) {
    $url = 'https://catalog.unl.edu/undergraduate/majors/';
    $html = file_get_contents($url);

    $crawler = new Crawler($html, $url);

    $nodes = $crawler->filter($selector.' .item-name');

    $majors = [];
    
    foreach ($nodes as $node) {
        $majors[] = $node->nodeValue;
    }
    
    return $majors;
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
