# Tags

This project defines a set of tags that can be used by UNL to identify and group like content. The tags are controlled and can form a sort of taxonomy.

## Status

Current status: `prototype`

## Goals

* Define a core set of common tags
* Avoid adding tags that have a limited use. If required, these tags can be added on a per-site/system basis in a 'free tags' field.
* The addition/removal of tags needs to be reviewed

## Usage

Tags are identified as a flat list to support the widest range of systems, but we also define a taxonomy with parent child relationships (hopefully for future use).

### Generating tags

`php scrips/generate.php` will compile the tags and create the appropriate files.

### Getting tags

Tags are located in two files

1. `data/flat.json` - defines a flat list of tags that can be used by other systems
2. `data/unl_tree.json` - defines a taxonomy (or hierarchy) of tags, from which relationships can be inferred.

### Integrating with systems

Each system will be different, but the general idea is to consume the `flat.json` file to populate a pre-defined list of tags that users can select. The system should also expose an API to get content by a given tag, which other systems can use to aggregate similar content.

## Combining tags

Scope can be reduced by combining tags.

To tag something as 'graduate research' you could give the content two tags: `graduate` and `research`. The combination of these tags implies that the content applies to both a graduate audience and is research oriented. This avoids adding a potentially redundant `graduate_research` tag.

## Ideas and ways to use

* Add API endpoints to interact with the unl_tree.json file. The API could allow for
  * searching for a tag
  * finding related tags (to show related content)
  * defining aliases for each tag
  * defining attributes such as a webpage for the tag to point to more information (cob could point to the business site)
* ???
