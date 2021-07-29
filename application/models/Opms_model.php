<?php
class opms_model extends CI_Model{
    public function __construct(){
        $this->opmsdb = $this->load->database('opms', TRUE);
    }
    public function region(){
        $query = $this->opmsdb->query("SELECT * FROM accounts_unit");
        return $query->result_array();
    }

    public function pto($from_date, $to_date, $region){
        $query = $this->opmsdb->query("
        select
   a.application_id as `OPMS No.`,
   a.reference_code as `Permit No.`,
   k.date_started AS `Application Date`,
   a.date_approved as `Date Approved`,
   a.date_expiration as `Date Expired`,
   c.name as `EMB Region`,
   a.name_of_establishment as `Name of Establishment`,
   a.ecc_cnc_no as `ECC / CNC`,
   -- concat(
--    	coalesce(a.mailing_street, ' '),
--         coalesce(g.name, ' '),
--         coalesce(h.name, ' '),
--         coalesce(i.name, ' '),
--         coalesce(j.name, ' ')
--    ) as `Office Address`,
   a.mailing_street as `Office Address`,
   g.name as `Region`,
   h.name as `Province`,
   i.name as `City/Municipality`,
   j.name as `Barangay`,
   a.plant_name as `Name of Plant`,
   -- concat(
--    	coalesce(a.plant_street, ' '),
--         coalesce(f.name, ' '),
--         coalesce(e.name, ' '),
--         coalesce(d.name, ' '),
--         coalesce(c.name, ' ')
--    ) as `Plant Address`,
   a.plant_street as `Plant Address`,
   g.name as `Region`,
   h.name as `Province`,
   i.name as `City/Municipality`,
   j.name as `Barangay`,
   a.plant_geolocation AS `Plant Geolocation`,
   a.nature_of_business AS `Business Nature`,
   a.operation_start_date AS `Date Operation Started`,
	case
		when b.status = 1 then 'Approved'
		when b.status = 2 then 'Disapproved'
		when b.status = 3 then 'In-process (EMB)'
		when b.status = 4 then 'Archived'
		when b.status = 5 then 'Pending (returned to applicant)'
	end as `Status`,
	case
		when a.date_expiration > CURRENT_DATE() then 'WITH PERMIT'
		ELSE 'WITHOUT PERMIT'
	end as `PTO`
from air_permittooperateapplication as a
left join (
		select id, STATUS, finalized
		from application_application
	) as b on b.id=a.application_id
left join (
		select name, id
		from accounts_unit
	) as c on c.id=a.unit_id
left join (
		select name, id
		from core_province
	) as d on d.id=a.plant_province_id
left join (
		select name, id
		from core_citymun
	) as e on e.id=a.plant_city_id
left join (
		select name, id
		from core_barangay
	) as f on f.id=a.plant_barangay_id
left join (
		select name, id
		from accounts_unit
	) as g on g.id=a.mailing_region_id
left join (
		select name, id
		from core_province
	) as h on h.id=a.mailing_province_id
left join (
		select name, id
		from core_citymun
	) as i on i.id=a.mailing_city_id
left join (
		select name, id
		from core_barangay
	) as j on j.id=a.mailing_barangay_id
left join (
		select
            application_id,
            min(released) as date_started
		from application_forward
        group by application_id
   ) as k on k.application_id=b.id
	where g.name = '".$region."' AND
    DATE(k.date_started) BETWEEN '".$from_date."' AND '".$to_date."' 
               ");

        return $query->result_array();
    }

    public function dp($from_date, $to_date, $region){
        $query = $this->opmsdb->query("
        select
	a.application_id as `OPMS No.`,
   a.reference_code as `Permit No.`,
   a.date_approved as `Date Approved`,
   CONCAT('20', substr(a.reference_code, 8, 2)) as `Year`,
   c.name as `EMB Region`,
   case
      when a.type_of_wastewater = 0 then 'Industrial'
      when a.type_of_wastewater = 1 then 'Commercial'
      when a.type_of_wastewater = 2 then 'Domestic Sewage'
      when a.type_of_wastewater = 3 then 'Combined (Industrial and Commercial)'
      when a.type_of_wastewater = 4 then 'Centralized Treatment Facility'
      when a.type_of_wastewater = 5 then 'Service Provider'
      else 'Unknown'
	end as `Type of Wastewater`,
   a.g_perm_name as `Office Name`,
   a.g_office_street as `Office Street`,
   # g.name as `Office Region`,  # for Region
   j.name as `Office Barangay`,
   i.name as `Office City`,
   h.name as `Office Province`,
--    concat(
--       coalesce(a.g_office_street, ' '),
--       coalesce(g.name, ' '),
--       coalesce(h.name, ' '),
--       coalesce(i.name, ' '),
--       coalesce(j.name, ' ')
--    ) as `Office Address`,
   coalesce(a.g_branch_name, '') as `Branch Name`,
   a.g_perm_ecc_no as `ECC`,
   a.g_perm_cnc_no as `CNC`,
   a.g_perm_plant_street as `Branch Street`,
   # c.name as `Branch Region`,  # for Region
   f.name as `Branch Barangay`,
   e.name as `Branch City`,
   d.name as `Branch Province`,
--    concat(
--       coalesce(a.g_perm_plant_street, ' '),
--       coalesce(f.name, ' '),
--       coalesce(e.name, ' '),
--       coalesce(d.name, ' '),
--       coalesce(c.name, ' ')
--    ) as `Branch Address`,
   a.g_perm_plant_geolocation AS `Branch Geolocation`,
   l.description as `Type of Industry`,
   a.swswg_gen_total as `Volume of WW Discharge per Month`,
   a.eo_prod_time_dwdpm as `Days per Month with Discharge`,
   a.eo_prod_time_mpy as `Months per Year with Discharge`,
   (a.eo_prod_time_dwdpm * a.eo_prod_time_mpy) as `Days of Operation in a year`,
   (a.swswg_gen_total * a.eo_prod_time_dwdpm * a.eo_prod_time_mpy) as `Volume of WW Discharge in a Year (cu.m / yr)`,
   coalesce(m.annual_prod_cap, '') as `Annual Production Capacity`,
   coalesce(m.actual_prod_prev, '') as `Actual Production in Previous year`,
   case
      when m.process_type = 0 then 'Batch'
      when m.process_type = 1 then 'Continuous'
      ELSE ''
	end as `Type of Process`,
   case
   	when a.wts_existing = 0 then 'No'
		when a.wts_existing = 1 then 'Yes'
	end as `Has Waste Treatment System`,
   coalesce(a.wts_capacity, 'Not available') as `Waste Treatment System Capacity (cu.m / day)`,
	case
		when a.wts_primary_exist = 0 then 'No'
		when a.wts_primary_exist = 1 then 'Yes'
	end as `Has Primary Treatment`,
	case
		when a.wts_secondary_exist = 0 then 'No'
		when a.wts_secondary_exist = 1 then 'Yes'
	end as `Has Secondary Treatment`,
	case
		when a.wts_chemical_exist = 0 then 'No'
		when a.wts_chemical_exist = 1 then 'Yes'
	end as `Has Chemical Treatment`,
	case
		when b.status = 1 then 'Approved'
		when b.status = 2 then 'Disapproved'
		when b.status = 3 then 'In-process (EMB)'
		when b.status = 4 then 'Archived'
		when b.status = 5 then 'Pending (applicant)'
	end as `Status`,
   k.date_started AS `Application Date`,
	case
		when a.date_approved > CURRENT_DATE() then 1
		ELSE 0
	end as `Valid Permit`,
	case
		when a.date_approved > CURRENT_DATE() then 'WITH PERMIT'
		ELSE 'WITHOUT PERMIT'
	end as `DP`,
   a.g_perm_pco_name as `PCO Name`,
   a.g_perm_pco_acc_no as `PCO Accreditation No.`,
   a.g_perm_pco_acc_date as `PCO Accreditation / Submission of Application Date`,
   a.g_perm_pco_tel as `PCO Tel No.`,
   a.g_perm_pco_fax as `PCO Fax No.`
from application_dischargepermit as a
left join (
		select id, STATUS, finalized
		from application_application
	) as b on b.id=a.application_id
left join (
		select name, id
		from accounts_unit
	) as c on c.id=a.unit_id
left join (
		select name, id
		from core_province
	) as d on d.id=a.g_perm_plant_province_id
left join (
		select name, id
		from core_citymun
	) as e on e.id=a.g_perm_plant_city_id
left join (
		select name, id
		from core_barangay
	) as f on f.id=a.g_perm_plant_barangay_id
left join (
		select name, id
		from accounts_unit
	) as g on g.id=a.g_office_region_id
left join (
		select name, id
		from core_province
	) as h on h.id=a.g_office_province_id
left join (
		select name, id
		from core_citymun
	) as i on i.id=a.g_office_city_id
left join (
		select name, id
		from core_barangay
	) as j on j.id=a.g_office_barangay_id
left join (
		select 
            application_id,
            min(released) as date_started
		from application_forward
        group by application_id
   ) as k on k.application_id=b.id
left JOIN (
		select description, id
		from application_industrycategory
	) as l on l.id=a.g_perm_type_of_ind
left JOIN (
      select
         DISTINCT
            ma.dp_id,
            group_concat(distinct annual_prod_cap_x SEPARATOR '; ') AS annual_prod_cap,
            group_concat(distinct actual_prod_prev_x SEPARATOR '; ') AS actual_prod_prev,
            group_concat(distinct ma.process_type SEPARATOR '; ') AS process_type
      from application_dpproduct AS ma
      LEFT JOIN (
         select
            dp_id,
            process_type,
            CONCAT_WS(' ', SUM(capacity), capacity_unit) AS annual_prod_cap_x
         from application_dpproduct
         GROUP BY dp_id, process_type, capacity_unit
      ) AS mb ON ma.dp_id = mb.dp_id AND ma.process_type = mb.process_type
      LEFT JOIN (
         select
            dp_id,
            process_type,
            CONCAT_WS(' ', SUM(prev_production), prev_production_unit) AS actual_prod_prev_x
         from application_dpproduct
         GROUP BY dp_id, process_type, prev_production_unit
      ) AS mc ON ma.dp_id = mc.dp_id AND ma.process_type = mc.process_type
      GROUP BY ma.dp_id
   ) as m on m.dp_id=a.id
		where c.name = '".$region."' AND
    DATE(k.date_started) BETWEEN '".$from_date."' AND '".$to_date."' 
               ");

        return $query->result_array();
    }

    public function sqi($from_date, $to_date, $region){
        $query = $this->opmsdb->query("
       select
	b.id as `OPMS No.`,
    case
		when b.status = 1 then a.reference_code
        else null
	end as `Certificate No.`,
    a.business_name as `Company Name`,
    case
		when a.category = 0 then 'Importer/Distributor'
		when a.category = 1 then 'Importer/End-user'
	end as `Applicant Category`,
    'SQI' as `Application Type`,
    c.name as `EMB Region`,
    i.chemical_name as `Chemical Name`,
    i.cas_no as `CAS No.`,
    case
		when b.status = 1 then a.annual_import
        else null
	end as `Quantity (Kg)`,
    c.name as `Region`,
    d.name as `Province`,
    e.name as `City/Municipality`,
    f.name as `Barangay`,
    g.date_started as `Date Started`,
    h.date_approved as `Date Approved`,
	case
		when b.status = 1 then 'Approved'
		when b.status = 2 then 'Disapproved'
		when b.status = 3 then 'In-process (EMB)'
		when b.status = 4 then 'Archived'
		when b.status = 5 then 'Pending (applicant)'
	end as `Status`
from application_smallquantityimportation as a
left join application_application as b on b.id=a.application_id
left join accounts_unit as c on c.id=a.unit_id
left join core_province as d on d.id=a.facility_province_id
left join core_citymun as e on e.id=a.facility_city_id
left join core_barangay as f on f.id=a.facility_barangay_id
left join (
		select
            application_id,
            min(released) as date_started
		from application_forward
        group by application_id
    ) as g on g.application_id=b.id
left join (
		select
            application_id,
            max(released) as date_approved
		from application_forward as aa
        left join application_actiontaken as ab on ab.id=aa.action_taken_id
        where ab.approve=True
        group by application_id
    ) as h on h.application_id=b.id
left join (
		select
			sqi_id,
			group_concat(name) as chemical_name,
            group_concat(cas_number) as cas_no
		from application_sqichemical
        group by sqi_id
	) as i on i.sqi_id=a.id
where
	(b.finalized=1 OR b.status=5)
   and g.date_started is not NULL
   and b.child_id is NULL
and c.name = '".$region."' AND
    DATE(g.date_started) BETWEEN '".$from_date."' AND '".$to_date."' 
order by a.reference_code, h.date_approved
               ");

        return $query->result_array();
    }

    public function coc($from_date, $to_date){
        $query = $this->opmsdb->query("
        select
        b.id as `OPMS No.`,
        case
            when b.status = 1 then a.reference_code
            else null
        end as `Certificate No.`,
        'COC' as `Application Type`,
        'Central' as `EMB Region`,
        g.date_started as `Date Started`,
        h.date_approved as `Date Approved`,
        case
            when b.status = 1 then 'Approved'
            when b.status = 2 then 'Disapproved'
            when b.status = 3 then 'In-process (EMB)'
            when b.status = 4 then 'Archived'
            when b.status = 5 then 'Pending (applicant)'
        end as `Status`
    from application_certificateofconformityapplication as a
    left join application_application as b on b.id=a.application_id
    left join (
            select
                application_id,
                min(released) as date_started
            from application_forward
            group by application_id
        ) as g on g.application_id=b.id
    left join (
            select
                application_id,
                max(released) as date_approved
            from application_forward as aa
            left join application_actiontaken as ab on ab.id=aa.action_taken_id
            where ab.approve=True
            group by application_id
        ) as h on h.application_id=b.id
    where
        (b.finalized=1 OR b.status=5)
       and g.date_started is not NULL
       and DATE(g.date_started) BETWEEN '".$from_date."' AND '".$to_date."' 
    order by a.reference_code, h.date_approved;
               ");

        return $query->result_array();
    }

    public function pcl($from_date, $to_date){
        $query = $this->opmsdb->query("
        select
        b.id as `OPMS No.`,
        case
            when b.status = 1 then a.reference_code
            else null
        end as `Certificate No.`,
        a.sec_name as `Company Name`,
        case
            when a.appl_type = 0 then 'Importer-Distributor'
            when a.appl_type = 1 then 'Importer-User-Manufacturer'
            when a.appl_type = 2 then 'User-Manufacturer'
        end as `Applicant Category`,
        case
            when a.pcl_type = 0 then 'PCL-C'
            when a.pcl_type = 1 then 'PCL-E'
        end as `Application Type`,
        'Central' as `EMB Region`,
        i.chemical_name as `Chemical Name`,
        i.cas_no as `CAS No.`,
        case
            when b.status != 1 then null
            else a.proj_amt
        end as `Quantity`,
        case
            when b.status != 1 then null
            when a.proj_amt_unit = 0 then 'MT'
            when a.proj_amt_unit = 1 then 'L'
            else null
        end as `Quantity Unit`,
        a.fac_addr as `Plant Address Full`,
        k.name as `Plant Address City/Municipality`,
        j.name as `Plant Address Province`,
        g.date_started as `Date Started`,
        h.date_approved as `Date Approved`,
        case
            when b.status = 1 then 'Approved'
            when b.status = 2 then 'Disapproved'
            when b.status = 3 then 'In-process (EMB)'
            when b.status = 4 then 'Archived'
            when b.status = 5 then 'Pending (applicant)'
        end as `Status`
    from application_pclapplication as a
    left join application_application as b on b.id=a.application_id
    left join (
            select
                application_id,
                min(released) as date_started
            from application_forward
            group by application_id
        ) as g on g.application_id=b.id
    left join (
            select
                application_id,
                max(released) as date_approved
            from application_forward as aa
            left join application_actiontaken as ab on ab.id=aa.action_taken_id
            where ab.approve=True
            group by application_id
        ) as h on h.application_id=b.id
    left join (
            select
                pcl_application_id,
                group_concat(name) as chemical_name,
                group_concat(cas_reg_num) as cas_no
            from application_chemicaltobeimported
            group by pcl_application_id
        ) as i on i.pcl_application_id=a.id
    left join core_province as j on concat('%' + upper(j.name) + '%') like upper(a.fac_addr)
    left join core_citymun as k on concat('%' + upper(k.name) + '%') like upper(a.fac_addr)
    where
        (b.finalized=1 OR b.status=5)
       and g.date_started is not NULL
    and DATE(g.date_started) BETWEEN '".$from_date."' AND '".$to_date."' 
    order by a.reference_code, h.date_approved;
               ");

        return $query->result_array();
    }

    public function pmpin($from_date, $to_date){
        $query = $this->opmsdb->query("
        select
	b.id as `OPMS No.`,
    case
		when b.status = 1 then a.reference_code
        else null
	end as `Certificate No.`,
    case
		when a.new_or_renew = 0 then 'New'
		when a.new_or_renew = 1 then 'Renewal'
		when a.new_or_renew = 2 then 'Amendment'
	end as `New/Amendment`,
    a.premise_name as `Company Name`,
    case
		when a.pmpin_type = 0 then 'Manufacture'
		when a.pmpin_type = 1 then 'Import-Distribute'
		when a.pmpin_type = 2 then 'Import-Distribute-Use'
		when a.pmpin_type = 3 then 'Import-Use'
	end as `Applicant Category`,
    case
		when a.pmpin_application_type = 0 then 'PMPIN-D'
        when a.pmpin_application_type = 1 then 'PMPIN-A'
	end as `Application Type`,
    'Central' as `EMB Region`,
    a.cas_name as `Chemical Name`,
    a.cas_number as `CAS No.`,
    a.total_quantity as `Quantity (Kg)`,
    a.premise_location as `Plant Address`,
    g.date_started as `Date Started`,
    h.date_approved as `Date Approved`,
	case
		when b.status = 1 then 'Approved'
		when b.status = 2 then 'Disapproved'
		when b.status = 3 then 'In-process (EMB)'
		when b.status = 4 then 'Archived'
		when b.status = 5 then 'Pending (applicant)'
	end as `Status`
from application_pmpinapplication as a
left join application_application as b on b.id=a.application_id
left join (
		select
            application_id,
            min(released) as date_started
		from application_forward
        group by application_id
    ) as g on g.application_id=b.id
left join (
		select
            application_id,
            max(released) as date_approved
		from application_forward as aa
        left join application_actiontaken as ab on ab.id=aa.action_taken_id
        where ab.approve=True
        group by application_id
    ) as h on h.application_id=b.id
where
	g.date_started is not NULL
    and DATE(g.date_started) BETWEEN '".$from_date."' AND '".$to_date."' 
    order by b.id;
               ");

        return $query->result_array();
    }

    public function ccor($from_date, $to_date, $region){
        $query = $this->opmsdb->query("
select
	b.id as `OPMS No.`,
    case
		when b.status = 1 then a.reference_code
        else null
	end as `Certificate No.`,
    a.company_name as `Company Name`,
    'CCO-R' as `Application Type`,
    case
		when a.chemical_type = 1 then 'Asbestos'
		when a.chemical_type = 2 then 'Mercury and Mercury Compound'
		when a.chemical_type = 3 then 'Cyanide and Cyanide Compound'
		when a.chemical_type = 4 then 'Lead and Lead Compound'
	end as `Chemical Group`,
    c.name as `EMB Region`,
    i.chemical_name as `Chemical Name`,
    i.cas_no as `CAS No.`,
    case
		when b.status = 1 then i.quantity
        else null
	end as `Quantity (MT)`,
    c.name as `Region`,
    d.name as `Province`,
    e.name as `City/Municipality`,
    f.name as `Barangay`,
    g.date_started as `Date Started`,
    h.date_approved as `Date Approved`,
	case
		when b.status = 1 then 'Approved'
		when b.status = 2 then 'Disapproved'
		when b.status = 3 then 'In-process (EMB)'
		when b.status = 4 then 'Archived'
		when b.status = 5 then 'Pending (applicant)'
	end as `Status`
from application_ccoregistration as a
left join application_application as b on b.id=a.application_id
left join accounts_unit as c on c.id=a.unit_id
left join core_province as d on d.id=a.plant_addr_province_id
left join core_citymun as e on e.id=a.plant_addr_city_id
left join core_barangay as f on f.id=a.plant_addr_barangay_id
left join (
		select
            application_id,
            min(released) as date_started
		from application_forward
        group by application_id
    ) as g on g.application_id=b.id
left join (
		select
            application_id,
            max(released) as date_approved
		from application_forward as aa
        left join application_actiontaken as ab on ab.id=aa.action_taken_id
        where ab.approve=True
        group by application_id
    ) as h on h.application_id=b.id
left join (
		select
			cco_registration_id,
			group_concat(chemical_name) as chemical_name,
            group_concat(cas_number) as cas_no,
            case
				when sum(t_imported) != 0 then sum(t_imported)
                when sum(t_used) != 0 then sum(t_used)
                when sum(t_distributed) != 0 then sum(t_distributed)
                when sum(t_lead_treated) != 0 then sum(t_lead_treated)
                else 0
			end as quantity
		from application_ccorchemicalinformation
        group by cco_registration_id
	) as i on i.cco_registration_id=a.id
where
	(b.finalized=1 OR b.status=5)
   and g.date_started is not NULL
   and b.child_id is NULL
    and c.name = '".$region."' AND
    DATE(g.date_started) BETWEEN '".$from_date."' AND '".$to_date."' 
    order by a.reference_code, h.date_approved
               ");

        return $query->result_array();
    }

    public function ccoi($from_date, $to_date, $region){
        $query = $this->opmsdb->query("
        select
            b.id as `OPMS No.`,
            case
                when b.status = 1 then a.reference_code
                else null
            end as `Certificate No.`,
            a.applicant_name as `Company Name`,
            case
                when a.category = 0 then 'Importer'
                when a.category = 1 then 'Distributor'
                when a.category = 2 then 'Importer/User'
                when a.category = 3 then 'Importer/Distributor'
                when a.category = 4 then 'Importer/Distributor/User'
                when a.category = 5 then 'End-user'
            end as `Applicant Category`,
            'CCO-IC' as `Application Type`,
            case
                when k.chemical_type = 1 then 'Asbestos'
                when k.chemical_type = 2 then 'Mercury and Mercury Compound'
                when k.chemical_type = 3 then 'Cyanide and Cyanide Compound'
                when k.chemical_type = 4 then 'Lead and Lead Compound'
            end as `Chemical Group`,
            c.name as `EMB Region`,
            i.chemical_name as `Chemical Name`,
            i.cas_no as `CAS No.`,
            case
                when b.status = 1 then i.quantity
                else null
            end as `Quantity in Certificate (MT)`,
            case
                when b.status = 1 then j.quantity
                else null
            end as `Actual Quantity (MT)`,
            c.name as `Region`,
            d.name as `Province`,
            e.name as `City/Municipality`,
            f.name as `Barangay`,
            g.date_started as `Date Started`,
            h.date_approved as `Date Approved`,
            case
                when b.status = 1 then 'Approved'
                when b.status = 2 then 'Disapproved'
                when b.status = 3 then 'In-process (EMB)'
                when b.status = 4 then 'Archived'
                when b.status = 5 then 'Pending (applicant)'
            end as `Status`
        from application_ccoimportation as a
        left join application_application as b on b.id=a.application_id
        left join accounts_unit as c on c.id=a.unit_id
        left join core_province as d on d.id=a.plant_addr_province_id
        left join core_citymun as e on e.id=a.plant_addr_city_id
        left join core_barangay as f on f.id=a.plant_addr_barangay_id
        left join (
                select
                    application_id,
                    min(released) as date_started
                from application_forward
                group by application_id
            ) as g on g.application_id=b.id
        left join (
                select
                    application_id,
                    max(released) as date_approved
                from application_forward as aa
                left join application_actiontaken as ab on ab.id=aa.action_taken_id
                where ab.approve=True
                group by application_id
            ) as h on h.application_id=b.id
        left join (
                select
                    id,
                    chemical_name,
                    cas_number as cas_no,
                    case
                        when t_imported != 0 then t_imported
                        when t_used != 0 then t_used
                        else 0
                    end as quantity
                from application_ccorchemicalinformation
            ) as i on i.id=a.chemical_id
        left join (
                select
                    related_application_id,
                    sum(volume) as quantity
                from application_inventorytrackingtransaction as ba
                left join application_inventorytrackingtransactiontype as bb on bb.id=ba.typ_id
                where
                    bb.import_type = 1
                    and ba.related_application_id is not NULL
                group by related_application_id
            ) as j on j.related_application_id=b.id
        left join application_ccoregistration as k on k.id=a.registration_id
        where
            g.date_started is not NULL
            and b.child_id is NULL
    and c.name = '".$region."' AND
    DATE(g.date_started) BETWEEN '".$from_date."' AND '".$to_date."' 
    order by a.reference_code, h.date_approved
               ");

        return $query->result_array();
    }

    public function odsir($from_date, $to_date){
        $query = $this->opmsdb->query("
        select
	b.id as `OPMS No.`,
    a.bus_name as `Company Name`,
    case
		when a.is_id = 1 then 'Importer - Distributor'
		when a.is_iu = 1 then 'Importer - End-user'
	end as `Applicant Category`,
    'ODS-IR' as `Application Type`,
    'Central' as `EMB Region`,
    a.sub_name as `Chemical Name`,
    NULL as `CAS No.`,
    case
		when b.status = 1 then a.allotment_weight
        else null
	end as `Quantity (Kg)`,
    case
		when a.is_id = True then ido.name
		when a.is_iu = True then iuo.name
		else NULL
	end as `Region`,
    case
		when a.is_id = True then ida.name
		when a.is_iu = True then iua.name
		else NULL
	end as `Province`,
    case
		when a.is_id = True then idb.name
		when a.is_iu = True then iub.name
		else NULL
	end as `City/Municipality`,
    case
		when a.is_id = True then idc.name
		when a.is_iu = True then iuc.name
		else NULL
	end as `Barangay`,
    case
		when a.is_id = True then a.id_geolocation
		when a.is_iu = True then a.iu_geolocation
		else NULL
	end as `Geolocation`,
    g.date_started as `Date Started`,
    h.date_approved as `Date Approved`,
	case
		when b.status = 1 then 'Approved'
		when b.status = 2 then 'Disapproved'
		when b.status = 3 then 'In-process (EMB)'
		when b.status = 4 then 'Archived'
		when b.status = 5 then 'Pending (applicant)'
	end as `Status`
from application_odsiregistration as a
left join application_application as b on b.id=a.application_id
left join accounts_unit as ido on ido.id=a.id_region_id
left join core_province as ida on ida.id=a.id_province_id
left join core_citymun as idb on idb.id=a.id_city_id
left join core_barangay as idc on idc.id=a.id_barangay_id
left join accounts_unit as iuo on iuo.id=a.iu_region_id
left join core_province as iua on iua.id=a.iu_province_id
left join core_citymun as iub on iub.id=a.iu_city_id
left join core_barangay as iuc on iuc.id=a.iu_barangay_id
left join (
		select
            application_id,
            min(released) as date_started
		from application_forward
        group by application_id
    ) as g on g.application_id=b.id
left join (
		select
            application_id,
            max(released) as date_approved
		from application_forward as aa
        left join application_actiontaken as ab on ab.id=aa.action_taken_id
        where ab.approve=True
        group by application_id
    ) as h on h.application_id=b.id
where
	(b.finalized=1
    OR b.status=5)
    and g.date_started is not NULL
    AND DATE(g.date_started) BETWEEN '".$from_date."' AND '".$to_date."' 
    order by a.reference_code, h.date_approved
               ");

        return $query->result_array();
    }

    public function odsic($from_date, $to_date){
        $query = $this->opmsdb->query("
        select
	b.id as `OPMS No.`,
    a.bus_name as `Company Name`,
    case
		when a.is_id = 1 then 'Importer - Distributor'
		when a.is_iu = 1 then 'Importer - End-user'
	end as `Applicant Category`,
    'ODS-IC' as `Application Type`,
    'Central' as `EMB Region`,
    a.sub_trade_name as `Chemical Name`,
    NULL as `CAS No.`,
    case
		when b.status = 1 then a.sub_quantity
        else null
	end as `Quantity (Kg)`,
    case
		when a.is_id = True then ido.name
		when a.is_iu = True then iuo.name
		else NULL
	end as `Region`,
    case
		when a.is_id = True then ida.name
		when a.is_iu = True then iua.name
		else NULL
	end as `Province`,
    case
		when a.is_id = True then idb.name
		when a.is_iu = True then iub.name
		else NULL
	end as `City/Municipality`,
    case
		when a.is_id = True then idc.name
		when a.is_iu = True then iuc.name
		else NULL
	end as `Barangay`,
    case
		when ir.is_id = True then ir.id_geolocation
		when ir.is_iu = True then ir.iu_geolocation
		else NULL
	end as `Geolocation`,
    g.date_started as `Date Started`,
    h.date_approved as `Date Approved`,
	case
		when b.status = 1 then 'Approved'
		when b.status = 2 then 'Disapproved'
		when b.status = 3 then 'In-process (EMB)'
		when b.status = 4 then 'Archived'
		when b.status = 5 then 'Pending (applicant)'
	end as `Status`
from application_odsimportationclearance as a
left join application_application as b on b.id=a.application_id
left join accounts_unit as ido on ido.id=a.id_region_id
left join core_province as ida on ida.id=a.id_province_id
left join core_citymun as idb on idb.id=a.id_city_id
left join core_barangay as idc on idc.id=a.id_barangay_id
left join accounts_unit as iuo on iuo.id=a.iu_region_id
left join core_province as iua on iua.id=a.iu_province_id
left join core_citymun as iub on iub.id=a.iu_city_id
left join core_barangay as iuc on iuc.id=a.iu_barangay_id
left join application_odsiregistration as ir on ir.id=a.odsir_id
left join (
		select
            application_id,
            min(released) as date_started
		from application_forward
        group by application_id
    ) as g on g.application_id=b.id
left join (
		select
            application_id,
            max(released) as date_approved
		from application_forward as aa
        left join application_actiontaken as ab on ab.id=aa.action_taken_id
        where ab.approve=True
        group by application_id
    ) as h on h.application_id=b.id
where
	(b.finalized=1 OR b.status=5)
   and g.date_started is not NULL
    AND DATE(g.date_started) BETWEEN '".$from_date."' AND '".$to_date."' 
    order by a.reference_code, h.date_approved
               ");

        return $query->result_array();
    }

    public function odsr($from_date, $to_date, $region){
        $query = $this->opmsdb->query("
        select
	b.id as `OPMS No.`,
    a.comp_name as `Company Name`,
    'ODS-R' as `Application Type`,
    c.name as `EMB Region`,
    i.chemical_name as `Chemical Name`,
    i.cas_no as `CAS No.`,
    case
		when b.status = 1 then i.quantity
        else null
	end as `Quantity (Kg)`,
    c.name as `Region`,
    d.name as `Province`,
    e.name as `City/Municipality`,
    f.name as `Barangay`,
    a.storage_geolocation as `Geolocation`,
    g.date_started as `Date Started`,
    h.date_approved as `Date Approved`,
	case
		when b.status = 1 then 'Approved'
		when b.status = 2 then 'Disapproved'
		when b.status = 3 then 'In-process (EMB)'
		when b.status = 4 then 'Archived'
		when b.status = 5 then 'Pending (applicant)'
	end as `Status`
from application_odsdsregistration as a
left join application_application as b on b.id=a.application_id
left join accounts_unit as c on c.id=a.unit_id
left join core_province as d on d.id=a.storage_province_id
left join core_citymun as e on e.id=a.storage_city_id
left join core_barangay as f on f.id=a.storage_barangay_id
left join (
		select
            application_id,
            min(released) as date_started
		from application_forward
        group by application_id
    ) as g on g.application_id=b.id
left join (
		select
            application_id,
            max(released) as date_approved
		from application_forward as aa
        left join application_actiontaken as ab on ab.id=aa.action_taken_id
        where ab.approve=True
        group by application_id
    ) as h on h.application_id=b.id
left join (
		select
			odsdsreg_id,
			group_concat(name) as chemical_name,
            NULL as cas_no,
            sum(quantity) as quantity
		from application_odsdssale
        where sale_type=1
        group by odsdsreg_id
	) as i on i.odsdsreg_id=a.id
where
	(b.finalized=1
    OR b.status=5)
    and g.date_started is not NULL
    and c.name = '".$region."' AND
    DATE(g.date_started) BETWEEN '".$from_date."' AND '".$to_date."' 
    order by a.reference_code, h.date_approved
               ");

        return $query->result_array();
    }

}
?>