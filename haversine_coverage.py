from math import radians, cos, sin, asin, sqrt

# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
# FUNCTIONS

def haversine(lat1, lng1, lat2, lng2):
    lng1, lat1, lng2, lat2 = map(radians, [lng1, lat1, lng2, lat2])
    dlon = lng2 - lng1 
    dlat = lat2 - lat1 
    a = sin(dlat/2)**2 + cos(lat1) * cos(lat2) * sin(dlon/2)**2
    c = 2 * asin(sqrt(a)) 
    r = 6371
    return c * r

def count_locations_covered(shopper, locations):
    locations_covered = 0

    for location in locations:
        km = haversine(shopper['lat'], shopper['lng'], location['lat'], location['lng'])
        if(km < 10):
            locations_covered += 1
    
    return locations_covered

def calculate_coverage(shoppers, locations):

    shoppers_coverage = []

    for shopper in shoppers:
        
        # find how many locations are covered (closer than 10 km) from shopper
        locations_covered = count_locations_covered(shopper, locations)

        # calculate the percentage based on the total number of enabled shoppers
        percentage = locations_covered * 100 / len(shoppers)

        shoppers_coverage.append({
            'shopper_id':shopper['id'],
            'coverage': percentage
        })

    return shoppers_coverage

# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


shoppers = [
    {'id': 'S1', 'lat': 45.46, 'lng': 11.03, 'enabled': True},
    {'id': 'S2', 'lat': 45.46, 'lng': 10.12, 'enabled': True},
    {'id': 'S3', 'lat': 45.34, 'lng': 10.81, 'enabled': True},
    {'id': 'S4', 'lat': 45.76, 'lng': 10.57, 'enabled': False},
    {'id': 'S5', 'lat': 45.34, 'lng': 10.63, 'enabled': True},
    {'id': 'S6', 'lat': 45.42, 'lng': 10.81, 'enabled': True},
    {'id': 'S7', 'lat': 45.34, 'lng': 10.94, 'enabled': False},
]

locations = [
    {'id': 1000, 'zip_code': '37069', 'lat': 45.35, 'lng': 10.84},
    {'id': 1001, 'zip_code': '37121', 'lat': 45.44, 'lng': 10.99},
    {'id': 1001, 'zip_code': '37129', 'lat': 45.44, 'lng': 11.00},
    {'id': 1001, 'zip_code': '37133', 'lat': 45.43, 'lng': 11.02}
]


# filter only enabled shoppers
enabled_shoppers = list(filter(lambda x: x.get('enabled'), shoppers))

# calculate coverage for every enabled shoppers
unsorted_coverage = calculate_coverage(enabled_shoppers, locations)

# sorting by coverage DESC
sorted_coverage = sorted(unsorted_coverage, key=lambda x: x.get('coverage'), reverse=True)

print(sorted_coverage)

# to see the output run in terminal: "python haversine_coverage.py" OR "python3 haversine_coverage.py"